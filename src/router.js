import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      children:[
        {
          path: '/:i',
          name: 'page',
          component: () => import( './views/home/'),
          children:[]
        },
        {
          path: '/',
          name: 'index',
          component: () => import( './views/home/')
        },{
          path: '/search/:i',
          name: 'search',
          component: () => import( './views/home/search.vue'),
          children:[]
        },{
          path: '/tag/:i',
          name: 'tag',
          component: () => import( './views/home/tag.vue'),
          children:[]
        },{
          path: '/article/:i',
          name: 'article',
          component: () => import( './views/home/article.vue'),
          children:[]
        },{
          path: '/login',
          name: 'login',
          component: () => import( './views/home/user/login.vue'),
          children:[]
        }
      ]
    },
    {
      path: '/about',
      name: 'about',
      component: () => import( './views/home/About.vue')
    },
    {
      path: "*",
      redirect: "/"
    }
  ]
})
