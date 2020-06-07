<template>
  <div>
    <guest-slip-gaji />
    <div class="back" @click="back()">
      <img src="./../assets/chev_left.png" alt="">
      <span>Kembali</span>
    </div>
    <div class="as-guest-wrapper">
      <div class="card" v-for="(item, index) in listMenu" :key="index" @click="showModal(item.key)">
        <div class="card-body">
          <img :src="require(`./../assets/${item.img}.png`)" :alt="item" srcset="">
          <p>{{ item.text }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
.back {
  padding-top: 20px;
  display: inline-block;
  cursor: pointer;
  &:hover {
    span {
      color: rgba(0, 0, 0, 0.7);
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
.as-guest-wrapper {
  padding-top: 20px;
  padding-bottom: 20px;
  box-sizing: border-box;
  display: flex;
  flex-wrap: wrap;
  .card {
    min-width: 200px;
    height: 200px;
    overflow: hidden;
    margin: 2px 4px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    flex-direction: column;
    transform: scale(1.1);
    opacity: 0;
    transition: opacity 1s, transform 1s;
    &.normal {
      opacity: 1;
      transform: scale(1);
    }
    &:hover {
      box-shadow: 0px 0px 4px 0px #A0A0A060;
    }
    p {
      width: 100%;
      text-align: center;
      font-weight: 800;
      padding: 14px;
    }
  }
}
</style>

<script>
import GuestSlipGaji from '@/components/GuestSlipGaji'
import $ from 'jquery'
export default {
  components: {
    GuestSlipGaji
  },
  data () {
    return {
      listMenu: [
        {
          img: 'slip_gaji_guest',
          text: 'Slip Gaji',
          key: 'slipGaji'
        }
      ]
    }
  },
  methods: {
    back () {
      this.$emit('back')
    },
    showModal (key) {
      $(`#show-modal-guest-${key}`).trigger('click')
    }
  },
  created () {
    setTimeout(() => {
      let card = document.querySelectorAll('.card')
      card.forEach((el, idx) => {
        setTimeout(() => {
          el.classList.add('normal')
        }, 100 * idx)
      })
    }, 100)
  }
}
</script>
