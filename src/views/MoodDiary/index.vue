<template>
  <div class="mood-diary" v-loading.fullscreen.lock = "loading">
    <topNav></topNav>
    <!-- <div class="radio">
      排序：
      <el-radio-group v-model="reverse">
        <el-radio :label="true">倒序</el-radio>
        <el-radio :label="false">正序</el-radio>
      </el-radio-group>
    </div> -->
    <div class="block">
      <el-timeline  :reverse="reverse">
        <el-timeline-item
          v-for="(item, index) in moods.data"
          :key="index"
          :color="item.mood"
          :timestamp="item.time">
          <span @click="speech(item.text)">{{item.text}}</span>
        </el-timeline-item>
      </el-timeline>
    </div>
    <div class="fix-bottom-action">
      <div class="action-item" @click="mood">
        <i class="el-icon-edit-outline"></i>
        <span>新心情</span>
      </div>
      <div class="action-item" @click="cate">
        <i class="el-icon-date"></i>
        <span>日期查看</span>
      </div>
      <div class="action-item" @click="scroll">
        <i class="el-icon-upload2" v-if="isTop"></i>
        <i class="el-icon-download" v-else></i>
        <span>回到顶部</span>
      </div>
      <div class="action-item" @click="close">
        <i class="el-icon-circle-close-outline"></i>
        <span>关闭</span>
      </div>
    </div>
    <div class="mask" v-if="isNewMood" @click="isNewMood = !isNewMood">
      <form class="mood-form" @click.stop>
        <div class="form-item">
          <el-input
            type="textarea"
            :autosize="{ minRows: 2, maxRows: 6}"
            ref="valInput"
            v-model="newMood.diary"
            placeholder="此刻,你想说些什么"></el-input>
          </div>
        <div class="form-item">
          <p>你现在的心情是?</p>
          <div class="mood-wrap">
            <el-radio v-for="(item, index) in moodArr"
            :key="index" v-model="newMood.addMode"
            :label="item.color"><i class="icon" :style="'color:'+item.color">{{item.ti}}</i></el-radio>
          </div>
        </div>
        <div class="form-item">
          <el-button @click="submit">提交</el-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import topNav from '@/components/topNav.vue'

 export default {
   data () {
     return {
       reverse: false,  // 排序
       isTop: false,   // 在顶部
       loading: true,  //加载中
       isNewMood: false,
       page: 1,
       moodArr: [{
         color: '#ff4081',
         ti: '不可说'
       },{
         color: '#E6A23C',
         ti: '不可名'
       },{
         color: '#F56C6C',
         ti: '急急急'
       },{
         color: '#67C23A',
         ti: 'Nice'
       },{
         color: '#909399',
         ti: '毫无波动'
       }],
       newMood: {
         diary: '',
         addMode: '#ff4081'
       },
       moods: {}
     }
   },
   components: {
    topNav
  },
   methods: {
     mood(){
       this.isNewMood = !this.isNewMood
       new Promise(()=>{
         setTimeout(()=>{
           this.$refs.valInput.focus()
         }, 666)
       })
     },
    //  提交新的内容
     submit() {
       if(/[\s\S]{5}/.test(this.newMood.diary)){
         this.$ajax.post('./MoodDiary.php', this.newMood).then((res)=>{
           console.log(res.data)
           let t = res.data
           if(t.data.code == 200){
              this.init()
              this.$message({
                message: 'Nice! 这条mood我已经记下了'+t.time,
                type: 'success'
              })
              this.isNewMood = !this.isNewMood
           }else{
            this.$message.error('未知错误')
            console.log(t)
           }
          })
          return 0
       }
        this.$message.error('请记录五个字符以上的心情')
       //console.log(this.newMood)
     },
     scroll(){
      return false
     },
     cate (){
       return false
     },
     close(){
       this.$router.push('/')
     },
     speech(val){
       this.loading = true
       this.tex2voice(val,6).then(()=>{
         this.loading = false
       })
     },
    //  读出来
     tex2voice(val, per){
      return new Promise((res,reject)=>{
        per = per?"&per="+per:'';
        let s =document.createElement('source'),a = document.createElement('audio');
        s.type ='audio/mp3';
        s.src = 'https://wx.qiatia.cn/admin/config/?ttsTex='+val+per;
        a.appendChild(s);
        a.autoplay = true;
        let item = 'tia'+ new Date().getTime()
        a.setAttribute('id',item)
        document.body.appendChild(a);
        let voice = document.getElementById(item)
        voice.onended = function(){
            console.warn('播放完毕,开始销毁=>')
            this.parentNode.removeChild(this)
        }
        voice.onplay= function(){
          res()
        }
      })
    },
     init() {
        this.$ajax.get('./MoodDiary.php?diary='+this.page).then((res)=>{
          this.moods = res.data
          // this.article = res.data
          this.loading = false
        }).catch((error)=> {
          console.log(error)
        })
     }
   },
   created() {
     this.init()
   }
 }
</script>

<style lang='less'>
.mood-diary{
  .block{
    padding: 16px;
    padding-bottom: 66px;
  }
  .fix-bottom-action{
    position: fixed;
    bottom: 0;
    left: 0;
    height: 61px;
    width: 100vw;
    background-color: #fff;
    box-shadow: 0 -2px 2px rgba(0, 0, 0, .12);
    display: flex;
    align-items: center;
    .action-item{
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      i{
        font-size: 24px;
      }
    }
  }
  .mask{
    position: fixed;
    width: 100vw;
    height: 100vh;
    z-index: 999;
    top: 0;
    left: 0;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    .mood-form{
      flex: 1;
      max-width: 550px;
      display: flex;
      flex-direction: column;
      padding: 16px;
      .form-item{
        flex: 1;
        width: 100%;
        display: flex;
        flex-direction: column;
        &+.form-item{
          margin-top: 8px;
        }
        p{
          color: #777;
          color: 17px;
        }
        .mood-wrap{
          display: flex;
          align-items: center;
          justify-content: center;
          flex-wrap: wrap;
          padding: 8px;
          label{
            flex:1;
            padding: 8px 0;
          }
        }
        textarea{
          width: 100%;
          padding: 8px;
          border: none;
          resize: none;
          font-size: 18px;
          color: #454;
          border-bottom: 2px solid rgba(0,0,0,.5);
          &:focus{
            outline: none;
            border-bottom-color: #ff4081;
          }
        }
      }
    }
  }
}
#viaplayer{
  display: none
}
</style>