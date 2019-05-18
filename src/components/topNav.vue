<template>
  <div class="header">
    <nav class="nav container" @click="closBar">
      <router-link class="meun-item" :to="'/'"><i class="icon">&#xe64f;</i></router-link>
      <a href="javascript:;" @click="toggleRightMeun" class="meun-item nav-meun-wapper right"><i class="icon">&#xe627;</i></a>
      <transition name="slide">
        <ul class="nav-meun right" v-show="isMax || isRightMeun">
          <!-- <li><a href="/"><img src="//i.qiatia.cn/public/qiatia/QiaTia.png" style="height:32px;border: 0;"></a></li> -->
          <li v-for="(item, index) in meun"  @click="toggleRightMeun" :key="index"><router-link :to="item.href">{{ item.name }}</router-link></li>
          <li @click="toggleBar"><a href="javascript:;"><span class="icon">&#xe651;</span></a></li>
          <li v-if="isLoginIn"><a href="javascript:;" @click="touchUserInfo">{{ $store.state.user.name }}</a></li>
          <li v-else><a href="javascript:;" @click="toggleLogin">登录</a></li>
        </ul>
      </transition>
    </nav>
    <transition name="fade">
      <div class="float-bar" v-show="isBar">
        <div class="search-wrapper container">
          <el-input placeholder="请输入内容" v-model="searchVal" class="input-with-select" @keyup.native.13="submitSearch">
            <template slot="prepend" @click="toggleBar">搜索</template>
            <el-button slot="append" icon="el-icon-search" @click="submitSearch"></el-button>
          </el-input>
        </div>
      </div>
    </transition>
    <transition name="fade">
      <div class="fix-login" v-show="isLogin" @click="toggleLogin">
        <login class="login-wrapper"
          :toggle-login='toggleLogin'
          :getLoginInfo='getLoginInfo'></login>
      </div>
    </transition>
  </div>
</template>

<script>
import login from '@/components/home/login.vue'

export default {
  name: 'topNav',
  data(){
    return {
      meun:[
        {
          name:'资源',
          href:'/tag/资源'
        },
        {
          name:'巧技',
          href:'/tag/巧技'
        },
        {
          name:'随笔',
          href:'/tag/随笔'
        }
      ],
      isBar: false,
      searchVal:'',
      cateVal:'',
      isRightMeun: false,
      isMax:true,
      isLogin:false,
      isLoginIn: !this.$store.state.user.name==undefined,
      userInfo: this.$store.state.user
    }
  },
  components: {
    login
  },
  methods:{
    toggleLogin:function (){
      this.isLogin = !this.isLogin
    },
    toggleBar:function(){
      this.isBar = !this.isBar
      event.cancelBubble = true
      this.isRightMeun = false
    },
    submitSearch:function(){
      this.$router.push('/search/' + this.searchVal)
      this.toggleBar()
    },
    closBar:function(){
      this.isBar = false
    },
    toggleRightMeun(){
      this.isRightMeun = !this.isRightMeun
    },
    // 获取登陆信息
    getLoginInfo(){
      this.$ajax.get('?loginUserInfo').then((response)=>{
        if(response.data.status == 200){
          // 已经登陆
          this.$store.commit('setUserInfo', response.data.info)
          this.isLoginIn = true
          // console.log(this.$store.state.user)
        }else{
          // 暂未登陆
          console.log(response.data, this.isLoginIn)
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    touchUserInfo(){
      //console.log(this.userInfo)
      this.$message({
        message: '欢迎回来! '+this.userInfo.name,
        type: 'success'
      })
    }
  },
  mounted () {
    const that = this
    window.onresize = () => {
      that.screenWidth = document.body.clientWidth
      if(that.screenWidth>600){
        this.isMax = true
      }else{
        this.isMax = false
      }
    }
    that.screenWidth = document.body.clientWidth
    if(that.screenWidth>600){
      this.isMax = true
    }else{
      this.isMax = false
    }
    //this.getLoginInfo()
  },
  // watch: {
  //   $route: function (){
  //     this.getLoginInfo()
  //     // 路由发生变化
  //   }
  // }
}
</script>

<style scoped lang="less">
.float-bar {
  position: relative;
  top: 0;
  z-index: 8;
  width: 100vw;
  background-color: #fff;
  padding-bottom: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, .15)
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.slide-enter-active, .slide-leave-active {
  transition: all .3s ease;
  overflow: hidden;
  max-height:200px;
}
.slide-enter, .slide-leave-to {
  max-height: 0;
}
.meun-item{
  color: #2c3e50;
  height: 100%;
  line-height: 51px;
  padding-left: 16px;
  padding-right: 16px;
  background: none, none, linear-gradient(-180deg, #42b983 -2px, #42b983 2px) no-repeat, none;
  background-position: center bottom;
  background-size: 0 1px,1px 0,0 1px,1px 0;
  transition: ease-in 0.2s;
  i{
    font-size: 22px;
  }
}
.header{
  height:56px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
  background-color: #fff;
  .nav-meun-wapper{display: none;}
  .fix-login{
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, .45);
    z-index: 1999;
    .login-wrapper{
      margin-top: 66px;
    }
  }
}
@media (max-width:600px){
  .header{
    .nav-meun-wapper{display: inline-block!important;}
    .nav-meun{
      position: relative;
      width: 100%;
      padding: 0 16px;
      text-align: right;
      left: 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
      li{
        display: block!important;
        border-bottom: solid 1px rgba(0, 0, 0, .15);
      }
    }
    .fix-login{
      background-color: #fff!important;
      .login-wrapper{
        margin-top: 0!important;
      }
    }
  }
}
.nav{
  height:51px;
  .nav-meun{
    line-height: 51px;
    display: inline-block;
    li{
      display: inline-block;
      color: #2c3e50;
      padding-left: 16px;
      padding-right: 16px;
      background:none,none,linear-gradient(-180deg,#42b983 -2px,#42b983 2px) no-repeat,none;
      background-position:center bottom;
      background-size:0 1px,1px 0,0 1px,1px 0;
      transition:ease-in .2s;
      a{
        color: #2c3e50;
        text-decoration: none;
      }
    }
    li:hover,.active{
      background-color: #eee;
      // border-bottom: 2px solid #42b983;
      background-size:0% 0px,0px 0%,100% 2px,0px 0%;
    }
  }
  .right{
    float: right;
  }
}
</style>