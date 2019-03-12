<template>
  <header class="polygons" @click="noToggle" v-loading.fullscreen.lock="fullscreenLoading">
    <a href="javascript:;" @click="toggleLogin"><span class="icon">&#xe641;</span></a>
    <h2 style="color: #626262">Login in</h2>
    <form class="login-wrapper"  style="display: block">
      <transition name="fade">
        <div class="content">
          <template v-if="isEmail">
            <el-input v-model="email" ref="emailInput" placeholder="Pleas input E-mail!"></el-input>
            <el-input placeholder="Pleas input code!" ref="codeInput" type="number" v-model="code">
             <el-button slot="append" @click="sendCode" v-text="codeInfo" :disabled='isCodeInfo'></el-button>
            </el-input>
          </template>
          <template v-else>
            <el-input v-model="name" ref="nameInput" placeholder="Pleas input account!"></el-input>
            <el-input v-model="pw" ref="pwInput" placeholder="Pleas input Password!"></el-input>
            <el-switch
              v-model="cookie"
              active-color="#13ce66"
              inactive-color="#aaa"
              active-text="记住密码"
              inactive-text="不记住密码">
            </el-switch>
          </template>
        </div>
      </transition>
        <div class="actions">
          <el-button type="success" style="float: right" @click="loginNow" class="btn" :disabled="noLogin">现在登录</el-button>
          <el-dropdown trigger="click" @command="handleCommand">
            <el-button type="info" class="btn">更多选项 <i class="el-icon-arrow-down el-icon--right"></i></el-button>
            <el-dropdown-menu slot="dropdown" >
              <el-dropdown-item command='0'>{{ isEmail?'密码登陆':'邮箱登陆' }}</el-dropdown-item>
              <!-- <el-dropdown-item command='1'>忘记密码</el-dropdown-item> -->
              <el-dropdown-item command='2'>新 账 号</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </form>
  </header>
</template>

<script>
 export default {
  data () {
     return {
      name:'',
      isEmail:true,
      pw:'',
      email:'',
      code:'',
      codeInfo:'发送验证码',
      cookie:false,
      isCodeInfo:false,
      noLogin:true,
      fullscreenLoading: false
     }
  },
  components: {
  },
  props: {
    toggleLogin: Function,
    getLoginInfo: Function
  },
  methods:{
    noToggle(){
      event.cancelBubble = true
    },
    swithLogin(){
      this.isEmail = !this.isEmail
    },
    handleCommand(command) {
      switch(command){
        case '0':
          this.swithLogin()
          break
        default:
          this.$message('click on item ' + command)
          break
      }
      //this.$message('click on item ' + command);
    },
    loginNow(){
      this.fullscreenLoading = true
      if(this.isEmail){
        // 邮箱登陆
        // 检验邮箱合法
        if(!this.isMail(this.email)){
          // 不合法
          this.$message.error('请检查你的邮箱格式!')
          this.$refs.emailInput.focus()
          return false
        }
        // 发送后台确认
        this.$ajax.get('?loginEmail='+this.email+'&code='+this.code).then((response)=>{
          // 获取到数据
          this.fullscreenLoading = false
          if(response.data.status == 200){
            // 成功登陆
            this.$message({
              message: response.data.info,
              type: 'success'
            })
            this.toggleLogin()
            this.getLoginInfo()
          }else{
            this.$refs.codeInput.focus()
            this.$message.error(response.data.error)
          }
        }).catch((error)=>{
          console.log(error)
        })
      }else{
        // 密码登陆
        this.$message.error('登陆失败, 未知错误!')
        this.fullscreenLoading = false
        this.toggleLogin()
        // this.$ajax.get('?loginPw='+this.name+'&code='+this.pw).then((response)=>{
        //   // 获取到数据
        //   this.fullscreenLoading = false
        //   if(response.data.status == 200){
        //     this.$message({
        //       message: response.data.info,
        //       type: 'success'
        //     })
        //   }else{
        //     this.$message.error(response.data.error)
        //   }
        // }).catch((error)=>{
        //   console.log(error)
        // })
      }
    },
    sendCode(){
      // 检验邮箱合法性
      if(!this.isMail(this.email)){
        // 合法
        this.$message.error('请检查你的邮箱格式!')
        this.$refs.emailInput.focus()
        return false
      }
      // 动画
      this.fullscreenLoading = true
      // 发送后台检验邮箱存在
      this.$ajax.get('?sendCode='+this.email).then((response)=>{
        // response.data 返回数据
        this.fullscreenLoading = false
        if(response.data.status == 200){
          // 收到合法  切换到倒计时
          this.isCodeInfo = true
          let rNum = 60
          let meter1 = setInterval(() => {
            this.codeInfo = rNum+'秒后再试';
            rNum--;
            if(rNum<0) {
              clearInterval(meter1);
              this.isCodeInfo = false;
              this.codeInfo = '重新发送验证码';
            }
          },1000)
          // 倒计时结束  切换到重新发送验证码
          this.$message({
            message: response.data.info,
            type: 'success'
          })
        }else{
          this.$message.error(response.data.error)
        }
      }).catch((error)=> {
        console.log(error)
      })
    },
    isMail(value){
      let mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/
      if(mailReg.test(value)){
        return true;
      }else{
        return false;
      }
    }
  },
  watch: {
    code: function (val) {
      if(val != '' && this.email != '') this.noLogin = false
      else this.noLogin = true
    },
  }
 }
</script>

<style scoped lang='less'>
.polygons{
  position: relative;
  max-width: 448px;
  background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zd…IiIHN0cm9rZT0iIzFhMmQ0MiIgc3Ryb2tlLXdpZHRoPSIxLjUxIj48L3BhdGg+Cjwvc3ZnPgo=),linear-gradient(to bottom,#1173d3,#4ac36c);
  background-position: 50% top;
  background-size: 100% 50%;
  background-color: #f1f1f1;
  padding-top: 175px;
  margin: 0 auto;
  a{
    position: absolute;
    top: 0;
    left:0;
    height: 38px;
    width: 38px;
    padding-left: 8px;
    border-radius: 50%;
    color: #eee;
    &:hover{
      background-color: rgba(0, 0, 0, .35)
    }
    span{
      font-size: 22px;
    }
  }
  h2{
    padding-left: 16px;
  }
  .login-wrapper{
    background-color: #fff;
    padding: 36px 16px 0;
    .content{
      .el-input,.el-switch{padding-bottom: 32px;}
    }
    .actions{
      padding-top: 16px;
      padding-bottom: 8px;
    }
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }
}
</style>