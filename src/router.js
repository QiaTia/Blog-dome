import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      meta:{ title:'QiaTia`小站' },
      children:[
        {
          path: '/page/:i',
          name: 'page',
          component: () => import( './views/home/'),
          children:[],
          meta:{ title:'PAGE - QiaTia`小站' },
        },
        {
          path: '/',
          name: 'index',
          component: () => import( './views/home/')
        },{
          path: '/search/:i',
          name: 'search',
          component: () => import( './views/home/search.vue'),
          children:[],
          meta:{ title:'搜索 - QiaTia`小站' },
        },{
          path: '/tag/:i',
          name: 'tag',
          component: () => import( './views/home/tag.vue'),
          children:[],
          meta:{ title:'标签 - QiaTia`小站' },
        },{
          path: '/article/:i',
          name: 'article',
          component: () => import( './views/home/article.vue'),
          children:[],
          meta:{ title:'文章 - QiaTia`小站' },
        },{
          path: '/login',
          name: 'login',
          component: () => import( './views/home/user/login.vue'),
          children:[],
          meta:{ title:'登陆 - QiaTia`小站' },
        }
      ]
    },
    {
      path: '/about',
      name: 'about',
      component: () => import( './views/home/About.vue'),
      meta:{ title:'关于 QiaTia`小站' },
    },{
      path: '/MoodDiary',
      name: 'MoodDiary',
      component: () => import( '@/views/MoodDiary/index'),
      meta:{title: "Mood Diary ` QiaTia"}
    },
    {
      path: "*",
      redirect: "/"
    }
  ]
})

router.beforeEach((to, from, next) => {//beforeEach是router的钩子函数，在进入路由前执行
  if (to.meta.title) {//判断是否有标题
    document.title = to.meta.title
  }
  next()//执行进入路由，如果不写就不会进入目标页
})
 
export default router