<template>
 <footer class="footer">
		<div class="foot typo">
      <div class="foot-about">
        <div class="title">» Hot label: </div>
        <div class="content">
          <router-link to="/tag/资源">Res</router-link>
          <router-link to="/search/Ajax">Ajax</router-link>
          <router-link to="/search/js">js</router-link>
          <router-link to="/search/CSS">CSS</router-link>
          <router-link to="/search/HTML">HTML</router-link>
          <router-link to="/search/Vue">Vue</router-link>
        </div>
      </div>
      <div class="foot-about">
        <div class="title">» About website: </div>
        <div class="content">
          Begin with interest, and be loyal to technology.
          </div>
      </div>
      <div class="foot-about">
        <div class="title">» Contact the: </div>
        <div class="content">
          <a href="mailto:QiaTia@qq.com">QiaTia@qq.com</a>
        </div>
      </div>
      <div class="foot-friends">
        <div class="title"><i class="icon to270">&#xe600;</i> My Friends:</div>
        <div class="content">
          <a href="http://timecost.top" target="_blank">TimeCost</a>
          <a href="https://www.v2ex.com/?r=QiaTia" target="_blank">V2EX</a>
        </div>
      </div>
    </div>
		<p class="copyright typo">Copyright 2018 <a href="javascript:;">QiaTia</a> | <a href="http://www.miitbeian.gov.cn" target="_blank">粤ICP备18119018</a></p>
	</footer>
</template>

<script>
export default {
  data() {
    return {};
  },
  components: {}
};
</script>

<style scoped lang='less'>
.footer{
  text-align: center;
  .foot{
    display: block;
    flex-wrap: wrap;
    background-color:#363533;
    color:#bbb;
    .foot-about{
      width: calc(100% / 3);
      display: inline-block;
      text-align: left;
      padding: 8px 16px;
      .title{
        line-height: 18px;
      }
      .content{
        font-size: 16px;
        word-break: break-all;
        word-wrap: break-word;
        padding: 0 16px;
        opacity: .7;
        a{
          margin-right: 3px;
          padding: 0 2px;
          color: #aaa;
        }
      }
    }
    .foot-friends{
      flex: 100%;
      text-align: left;
      padding:16px;
      .title{
        line-height: 18px;
      }
      .content{
        font-size: 16px;
        word-break: break-all;
        word-wrap: break-word;
        padding: 0 16px;
        opacity: .7;
        a{
          margin-right: 3px;
          padding: 0 2px;
          color: #aaa;
        }
      }
    }
  }
  .copyright{
    background-color: #292929;
    color: #6f6e67;
    font-size: 18px;
    line-height: 36px;
    a{
      color: #6f6e67;
    }
  }
}

</style>