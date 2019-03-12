<template>
  <div id="reply">
    <div class="reply-wrapper">
      <el-form :model="ruleForm" :rules="rules" ref="ruleForm" :inline="true">
        <el-input
          type="textarea"
          :autosize="{ minRows: 2, maxRows: 6}"
          placeholder="请输入回复内容"
          @focus='ryOnFocus'
          v-model="ruleForm.replyVal" ref="valInput"  style="margin-bottom: 8px;">
        </el-input>
         <transition name="slide-fade">
          <div v-if="isRbar && noLoginIn">
            <el-form-item label="Name">
              <el-input v-model="ruleForm.name" ref="nameInput" placeholder="Pleas input your name ." clearable></el-input>
            </el-form-item>
            <el-form-item label="Email">
              <el-input v-model="ruleForm.email" ref="emailInput" placeholder="Pleas input your email ." clearable></el-input>
            </el-form-item>
          </div>
         </transition>
      </el-form>
      <div class="option-bar">
        <el-button size="small" disabled icon="el-icon-loading" type="info">预留功能</el-button>
        <el-button class="reply-sumbit" size="small" @click="replySubmit">回复</el-button>
      </div>
    </div>
    <div class="reply-content-wrapper">
      <ul class="reply-content-list">
        <template v-if="replyList.length">
          <li class="list-item" v-for="(item, index) in replyList" :key="index">
            <div class="item-avatar">
              <img :src="'//qiatia.cn/images/user/'+item.avatar">
            </div>
            <div class="item-content">
              <div class="item-title"> <a href="javascript:;">{{ item.userName }}</a><span class="item-meta" v-text="item.time"></span> </div>
              <div class="item-text typo" v-html="item.con"></div>
            </div>
          </li>
        </template>
        <h3 v-else style="line-height:75px; height:75px;" align="center">还没人来评论哎，快来抢沙发吧</h3>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    var checkEmail = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('邮箱不能为空'));
      }
      setTimeout(() => {
        if (!Number.isInteger(value)) {
          callback(new Error('请输入数字值'));
        } else {
          if (value < 18) {
            callback(new Error('必须年满18岁'));
          } else {
            callback();
          }
        }
      }, 1000);
    };
    return {
      i:'',
      replyList: [],
      isRbar: false,
      noLoginIn: this.$store.state.user.name==undefined,
      ruleForm:{
        replyVal:'',
        name:'',
        email:''
      },rules: {
        name: [
          { required: true, message: '请输入呢称 ', trigger: 'blur' },
          { min: 3, max: 8, message: '长度在 3 到 8 个字符', trigger: 'blur' }
        ],
        email: [
          { validator: checkEmail, trigger: 'blur' }
        ],
      }
    }
  },
  methods:{
    // codeing
    ryOnFocus(){
      this.isRbar = true
    },
    ryOnBlur(){
      this.isRbar = false
    },
    onClean(){
      this.ruleForm.email = ''
      this.ruleForm.name = ''
    },
    replySubmit() {
      if(this.ruleForm.replyVal==''){
        this.$refs.valInput.focus()
        this.$message.error('请输入回复内容')
        return false
      }
      this.$ajax.get('?conId='+this.i+'&Remail='+this.ruleForm.email+'&Rname='+this.ruleForm.name+'&reply='+this.ruleForm.replyVal).then((response)=>{
        // 错误处理
        if(response.data.status != 200){
          this.$message.error(response.data.error)
          response.data.error.indexOf('邮箱')>0?this.$refs.emailInput.focus():this.$refs.nameInput.focus()
          return false
        }else{
          this.$message({
            message: response.data.info,
            type: 'success'
          })
          this.onClean()
          this.ryOnBlur()
          this.getReplyList()
          return true
        }
      }).catch((error)=> {
        console.log(error)
      })
    },
    getReplyList() {
      this.$ajax.get('?replyList='+this.i).then((response)=>{
        this.replyList = response.data
      }).catch((error)=> {console.log(error)})
    },
    // 获取登陆信息
    getLoginInfo(){
      this.$ajax.get('?loginUserInfo').then((response)=>{
        if(response.data.status == 200){
          // 已经登陆
          this.noLoginIn = false
          this.$store.commit('setUserInfo', response.data.info)
        }else{
          // 暂未登陆
          console.log(response.data)
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
  },
  created() {
    this.i = this.$route.params.i
    this.getReplyList()
    // this.getLoginInfo()
  }
 }
</script>
<style scoped lang='less'>
#reply{
  padding: 16px 8px;
  .option-bar{
    margin-top: 8px;
    margin-bottom: 16px;
    .reply-sumbit{
      float: right;
    }
  }
  .list-item{
    display: block;
    padding: 0 16px;
    padding-top: 16px;
    display: flex;
    min-height: 48px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    text-decoration: none;
    transition: background-color .3s cubic-bezier(.4,0,.2,1);
    align-items: center;
    .item-avatar{
      min-width: 40px;
      max-width: 40px;
      height: 40px;
      margin-top: 8px;
      margin-bottom: 8px;
      line-height: 40px;
      color: #fff;
      text-align: center;
      background-color: #bdbdbd;
      border-radius: 50%;
      img{
        width: 40px;
        height: 40px;
        border-radius: 50%;
      }
    }
    .item-content{
      margin-left: 16px;
      padding-top: 14px;
      padding-bottom: 14px;
      font-size: 16px;
      font-weight: 400;
      line-height: 20px;
      -webkit-box-flex: 1;
      -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
      flex-grow: 1;
      border-bottom: solid #eee 1px;
      .item-title{
        margin: 0;
        padding: 0;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
        border-bottom: dashed #eee 1px;
        a{color: #222; }
        .item-meta{
          font-size: 12px;
          display: inline-block;
          float: right;
          color: rgba(0,0,0,.54);
        }
      }
      .item-text{
        font-size: 14px;
        margin-top: 4px;
        line-height: 1.8;
        word-wrap: break-word;
        display: block;
        color: rgba(0,0,0,.54);
      }
      &>div{
        width: 100%;
      }
    }
  }
  .slide-fade-enter-active {
    transition: all .3s ease;
  }
  .slide-fade-leave-active {
    transition: all .3s ease;
  }
  .slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active for below version 2.1.8 */ {
    opacity: 0;
  }
}

</style>