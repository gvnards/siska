import Vue from 'vue'
import Router from 'vue-router'
import MainApp from '@/views/MainApp'
import Login from '@/views/Login'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Login',
      component: Login,
      beforeEnter: (to, from, next) => {
        next()
        if (this.a.app.$session.has('session-id') && this.a.app.$session.has('onLogin')) {
          this.a.app.$router.push({
            name: 'admin'
          })
        }
      }
    },
    {
      path: '/admin/',
      name: 'admin',
      component: MainApp,
      beforeEnter: (to, from, next) => {
        next()
        if (!this.a.app.$session.has('session-id') && !this.a.app.$session.has('onLogin')) {
          this.a.app.$router.push({
            name: 'Login'
          })
        }
        next()
      }
    }
  ]
})
