<template>
  <div id="as-admin-wrapper">
    <div class="card">
      <div class="card-header">
        <div @click="back()">
          <img src="./../assets/chev_left.png" alt="">
          <span>Kembali</span>
        </div>
      </div>
      <div class="card-body">
        <h4>Login</h4>
        <div class="form-group">
          <label for="inputUsername">Username</label>
          <input type="text" class="form-control" id="inputUsername" placeholder="Masukkan username" v-model="login.username">
        </div>
        <div class="form-group">
          <label for="inputUsername">Password</label>
          <input type="password" class="form-control" id="inputUsername" placeholder="Masukkan password" v-model="login.password">
        </div>
        <button class="btn btn-sm btn-block btn-primary" @click="onLogin()">Login</button>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
#as-admin-wrapper {
  display: flex;
  flex-wrap: wrap;
  position: relative;
  align-content: center;
  justify-content: center;
  min-height: 100vh;
  top: -100px;
  opacity: 0;
  &.toLeft {
    top: 0px;
    transition: 1s all;
    transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    opacity: 1;
  }
  .card {
    min-width: 28rem;
    min-height: 24rem;
    .card-header {
      div {
        display: inline-block;
        cursor: pointer;
        &:hover {
          span {
            color: rgba(0, 0, 0, 0.7);
          }
        }
      }
      img {
        width: 14px;
        height: 14px;
      }
      span {
        font-size: 12px;
      }
    }
    .card-body {
      h4 {
        padding-bottom: 12px;
        border-bottom: 1px solid #F0F0F0;
      }
    }
  }
}
</style>

<script>
import Axios from 'axios'
export default {
  data () {
    return {
      login: {
        username: '',
        password: ''
      }
    }
  },
  methods: {
    back () {
      this.$emit('back')
    },
    onLogin () {
      if (this.login.username !== '' && this.login.password !== '') {
        Axios({
          url: `${this.$store.state.BASED_URL}siska_server/index.php`,
          method: 'GET',
          params: {
            nocache: new Date().getTime(),
            onGet: 'Login',
            loginAs: 'admin',
            username: this.login.username,
            password: this.login.password
          }
        }).then(res => {
          if (res.data.callback) {
            this.$session.set('onLogin', this.login.username)
            this.$router.push({
              name: 'admin'
            })
          }
        })
      }
    }
  },
  created () {
    setTimeout(() => {
      document.getElementById('as-admin-wrapper').classList.add('toLeft')
    }, 100)
  }
}
</script>
