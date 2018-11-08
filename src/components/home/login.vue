<template>
  <header class="polygons" @click="noToggle">
    <a href="javascript:;" @click="toggleLogin"><span class="icon">&#xe641;</span></a>
    <h2 style="color: #626262">请输入账号密码</h2>
    <form class="login-wrapper"  style="display: block">
        <div class="content">
          <el-input v-model="name" placeholder="Pleas input account!"></el-input>
          <el-input v-model="pw" placeholder="Pleas input Password!"></el-input>
          <el-switch
            v-model="cookie"
            active-color="#13ce66"
            inactive-color="#aaa"
            active-text="记住密码"
            inactive-text="不记住密码">
          </el-switch>
        </div>
        <div class="actions">
          <el-button type="success" style="float: right" class="btn">现在登录</el-button>
          <el-dropdown>
            <el-button type="info" class="btn">更多选项 <i class="el-icon-arrow-down el-icon--right"></i></el-button>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>忘记密码</el-dropdown-item>
              <el-dropdown-item>新 账 号</el-dropdown-item>
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
      pw:'',
      cookie:false
     }
   },
   components: {
   },
   props: {
    toggleLogin: Function
  },
   methods:{
     noToggle:function(){
      event.cancelBubble = true
    }
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
}
</style>