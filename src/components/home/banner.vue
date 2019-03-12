<template>
 <div class="slide-banner">
    <a href="javascript:;" style="transform: rotate(180deg)" @click="move(600, 1)"><span class="icon">&#xe65f;</span></a>
    <ul class="slideshow" :style="slideStyle">
      <li class="banner" v-for="(item, index) in banner" :key="index">
        <img :src="item.src" :alt="item.title">
      </li>
      <li class="banner" v-for="(item, index) in banner" :key="index+10">
        <img :src="item.src" :alt="item.title">
      </li>
    </ul>
    <a href="javascript:;"  @click="move(600,-1)"><span class="icon">&#xe65f;</span></a>
  </div>
</template>

<script>
 export default {
  data () {
    return {
      banner:[],
      autoplay:4000,
      i:0,
      distance:0
    }
  },
  methods :{
    play() {
      if(this.timer) {
        window.clearInterval(this.timer)
        this.timer = null
      }
      this.timer = window.setInterval(() => {
        this.move(600, -1)
      }, this.autoplay)
    },
    move(offset, direction){
      this.stop()
      this.play()
      if(this.i - direction <0) {
        this.distance = -(this.banner.length * offset)
        this.i = this.banner.length
        return true
      }
      if(this.i*offset + direction >= (this.banner.length-1) * offset) {
        this.distance = 0
        this.i = 0
        return true
      }
      this.distance += offset*direction
      this.i =this.i-direction
    },
    stop() {
      window.clearInterval(this.timer)
      this.timer = null
    }
  },
  created (){
    this.$ajax.get('https://qiatia.cn/api/?banner').then((response)=>{
      this.banner = response.data
    }).catch((error)=>{
      console.log(error)
    })
    this.play()
  },
  computed:{
    slideStyle() {  //这里用了计算属性，用transform来移动整个图片列表
      return {
        transform:`translate3d(${this.distance}px, 0, 0)`
      }
    }
  }
 }
</script>

<style scoped lang='less'>
.slide-banner{
  margin-top: 8px;
  margin-bottom: 8px;
  height: 300px;
  overflow: hidden;
  position: relative;
  a{
    display: inline-block;
    position: absolute;
    z-index: 999;
    background-color: rgba(0, 0, 0, .2);
    height: 50px;
    width: 50px;
    line-height: 50px;
    text-align: center;
    border-radius: 50%;
    top:calc(50% - 30px);
    color: #999;
    span{
      font-size:32px;
    }
    &:last-child{
      right: 0
    }
    &:hover{
      background-color: rgba(0, 0, 0, .6);
      color: #bbb
    }
  }
  .slideshow{
    transition: all .3s ease-in-out;
    height: 100%;
    width: 999vw;
    .banner, .banner img{
      display: inline-block;
      height: 100%;
    }
  }
}
@media (max-width: 600px){
  .slide-banner{
    height: 200px;
    a{
      display: none;
    }
  }
} 
</style>