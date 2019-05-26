<template>
  <div class="error-container">
    <div class="error-401">
      <i class="icon">&#xe605;</i>
      <h1>你访问的页面找不到辣</h1>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {

    }
  },
  components: {

  }
}
</script>

<style scoped lang='less'>
.error-container{
  height: 450px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  .error-401{
    display: flex;
    flex-direction: column;
    align-items: center;
    i.icon{
      font-size: 66px;
      color: #ff945c;
    }
  }
}
</style>