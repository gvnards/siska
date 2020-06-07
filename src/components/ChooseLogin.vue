<template>
  <div id="choose-login-wrapper">
    <div class="card" v-for="(item, index) in chooseLogin" :key="index" @click="pickLogin(item.text)">
      <div class="card-body">
        <img :src="require(`./../assets/${item.img}.png`)" :alt="item" srcset="">
        <p>Masuk sebagai {{ item.text }}</p>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
#choose-login-wrapper {
  display: flex;
  flex-wrap: wrap;
  align-content: center;
  justify-content: center;
  min-height: 100vh;
  .card {
    width: 24rem;
    min-height: 12rem;
    margin: 4px;
    cursor: pointer;
    &:hover {
      box-shadow: 0px 0px 4px 0px #A0A0A060;
    }
    .card-body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      flex-direction: column;
      color: #808080;
      p {
        width: 100%;
        text-align: center;
        font-weight: 800;
        padding: 14px;
      }
    }
  }
}
</style>

<script>
export default {
  data () {
    return {
      chooseLogin: [
        {
          text: 'Tamu',
          img: 'guest'
        },
        {
          text: 'Admin',
          img: 'admin_account'
        }
      ]
    }
  },
  methods: {
    pickLogin (as) {
      this.$emit('pickLogin', as)
    }
  }
}
</script>
