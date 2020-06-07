<template>
  <div id="content-header">
    <h1>Selamat datang, {{ $store.state.account.nama }}<span v-if="$store.state.account.nama_jabatan.toLowerCase() === 'admin'"> {{ $store.state.account.nama_opd }}</span></h1>
    <h2>{{ $store.state.account.nama_jabatan }}</h2>
    <div class="circle">
      <img :src="require(`./../assets/${$store.state.menu.active.toLowerCase().split(' ').join('_')}_header.png`)" alt="">
    </div>
  </div>
</template>

<style lang="less" scoped>
h1 {
  color: black;
  font-size: 18px;
  font-weight: 600;
}
h2 {
  color: black;
  font-size: 14px;
  font-weight: 400;
  margin-top: 6px;
  margin-bottom: 6px;
}
#content-header {
  position: relative;
  min-height: 60px;
  border-bottom: 2px solid #C4C4C4;
  box-sizing: border-box;
  min-width: 600px;
  .circle {
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    box-sizing: border-box;
    border-radius: 50%;
    background-color: white;
    -webkit-box-shadow: 0px 0px 6px 0px rgba(112, 112, 112, 0.4);
    -moz-box-shadow: 0px 0px 6px 0px rgba(112, 112, 112, 0.4);
    box-shadow: 0px 0px 6px 0px rgba(112, 112, 112, 0.4);
    width: 40px;
    height: 40px;
    img {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      width: 30px;
      height: 30px;
    }
  }
}
</style>

<script>
export default {

}
</script>
