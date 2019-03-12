<template>
<div class="fix-nav">
  <div class="fix-progress">
    <div class="progress-determinate" v-bind:style="{ width: widthnum+'%' }"></div>
  </div>
  <a href="javascript:;" @click="upTop">
    <div class="up-top">
      <span class="icon">&#xe65d;</span>
    </div>
  </a>
 </div>
</template>

<script>
export default {
  data() {
    return{
      widthnum: 50
    }
  },
  methods: {
    upTop(){
      (function smoothscroll(){
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
          window.requestAnimationFrame(smoothscroll);
          window.scrollTo (0,currentScroll - (currentScroll/5));
        }
      })()
    }
   },
   mounted () {
    const that = this
    window.onscroll = ()=>{
      let t = document.documentElement.scrollTop || document.body.scrollTop,
          i = t / (document.body.offsetHeight - window.innerHeight);
      if (t >= 300) {
        document.querySelector('.up-top').style.bottom = '16px'
        document.querySelector('.up-top').style.right = '16px'
        document.querySelector('.fix-progress').style.display = 'block'
      }else{
        document.querySelector('.up-top').style.bottom = '25vh'
        document.querySelector('.up-top').style.right = '-36px'
        document.querySelector('.fix-progress').style.display = 'none'
      }
      that.widthnum = parseInt(i*100)
    }
   }
  }
</script>

<style scoped lang='less'>
.fix-progress{
  position: fixed;
  top: 0;left: 0;
  height: 2px;
  width: 100vw;
  display: none;
  background: rgba(0,0,0,.2);
  .progress-determinate{
    display: block;
    height: 100%;
    background-color: #42b983;
    transition: All .1s liner;
  }
}
.up-top{
  transition: All .4s cubic-bezier(0, 0, 0.93, 0.15);
  line-height: 33px;
  height: 33px;
  width: 33px;
  border-radius: 50%;
  display: block;
  position: fixed;
  right: -36px;
  bottom: 25vh;
  background-color: #898989;
  text-align: center;
  span{
    font-size: 18px;
    color: #eee;
  }
  &:hover {
    background-color: #898989aa;
    span{
      color: #42b983;
    }
  }
}
</style>