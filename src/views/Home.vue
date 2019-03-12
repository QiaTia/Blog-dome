<template>
  <div class="home">
    <topNav></topNav>
    <transition :name="transitionName">
      <router-view class="child-view"/>
    </transition>
    <bottomNav></bottomNav>
    <fixNav ref="mychild"></fixNav>
  </div>
</template>

<script>
// @ is an alias to /src
import topNav from '@/components/topNav.vue'
import bottomNav from '@/components/bottomNav.vue'
import fixNav from '@/components/fixNav.vue'

export default {
  name: 'home',
  data(){
    return{
      transitionName: 'slide-left',
      isLoginIn: this.$store.state.user.name==undefined,
      userInfo: this.$store.state.user
    }
  },
  components: {
    topNav,
    bottomNav,
    fixNav,
  },
  watch: {
    '$route' (to, from) {
      if(to.path == '/'){
        this.transitionName = 'slide-right';
      }else{
        this.transitionName = 'slide-left';
      }
      this.$refs.mychild.upTop()
    }
  }
}
</script>
<style lang="less">
.child-view {
  transition: all .5s cubic-bezier(.55,0,.1,1);
}
.slide-left-enter, .slide-right-leave-active {
  opacity: 0;
  transform: translate(30px, 0);
}
.slide-left-leave-active, .slide-right-enter {
  opacity: 0;
  transform: translate(-30px, 0);
}
</style>