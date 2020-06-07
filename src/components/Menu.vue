<template>
  <div id="menu-wrapper">
    <div class="head-menu">
      <img src="../assets/logo.png" alt="Logo Siska">
      <p>Layanan<br><span>SISKA</span></p>
    </div>
    <div class="body-menu">
      <div class="account-menu">
        <img src="../assets/admin_account.png" alt="Logo Akun">
        <div>
          <p>{{ $store.state.account.nama }}</p>
          <div class="online"></div>
          <span>Online</span>
        </div>
      </div>
      <div class="div-menu">
        <p>Menu Utama</p>
      </div>
      <div class="main-menu">
        <div class="menu-item" :class="item.text === $store.state.menu.active ? 'active' : ''" v-for="(item, index) in menu" :key="index" @click="pickMenu(item)">
          <img :src="require(`./../assets/${item.img}`)" alt="">
          <span>{{ item.text }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
#menu-wrapper {
  min-height: 100vh;
  min-width: 240px;
  max-width: 240px;
  .head-menu {
    cursor: pointer;
    color: white;
    padding-left: 10px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    background-color: #1E8F47;
    display: flex;
    align-items: center;
    width: 100%;
    height: 80px;
    img {
      width: 60px;
      height: 60px;
      margin-right: 5px;
    }
    p {
      margin: 0;
      padding: 0;
      font-size: 14px;
      font-weight: 400;
      span {
        font-size: 24px;
        font-weight: 600;
      }
    }
  }
  .body-menu {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    padding-left: 10px;
    height: calc(100vh - 80px);
    background-color: #223229;
    .account-menu {
      cursor: pointer;
      color: white;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      display: flex;
      align-items: center;
      min-height: 60px;
      position: relative;
      img {
        margin-right: 5px;
        width: 50px;
        height: 50px;
      }
      .online {
        width: 12px;
        height: 12px;
        background-color: #3C753D;
        display: inline-block;
        border-radius: 50%;
      }
      p {
        margin: 0;
        font-size: 12px;
        font-weight: 500;
      }
      span {
        font-size: 12px;
      }
    }
    .div-menu {
      height: 40px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      background-color: #1D261A;
      margin-left: -10px;
      p {
        margin: 0;
        padding-top: 12.5px;
        padding-left: 10px;
        font-size: 12px;
        font-weight: 400;
        color: #B0B0B0;
      }
    }
    .menu-item {
      color: white;
      height: 40px;
      display: flex;
      align-items: center;
      border-left: 3px solid transparent;
      padding-left: 10px;
      transition: 0.4s border-color;
      cursor: pointer;
      &:hover {
        border-color: white;
      }
      &.active {
        border-color: white;
      }
      img {
        width: 28px;
        height: 28px;
      }
      span {
        font-size: 16px;
        font-weight: 500;
        margin-left: 10px;
      }
    }
  }
}
</style>

<script>
export default {
  data () {
    return {
      menu: [
        {
          img: 'dasbor.png',
          text: 'Dasbor'
        },
        {
          img: 'slip_gaji.png',
          text: 'Slip Gaji'
        },
        {
          img: 'atur.png',
          text: 'Atur'
        },
        {
          img: 'logout.png',
          text: 'Keluar'
        }
      ]
    }
  },
  methods: {
    pickMenu (item) {
      if (item.text === 'Keluar') {
        this.$session.clear()
        this.$session.destroy()
        this.$router.push('/')
      } else this.$store.commit('SET_MENU_ACTIVE', item.text)
    }
  }
}
</script>
