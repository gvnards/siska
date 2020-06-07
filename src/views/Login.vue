<template>
  <div id="login-wrapper">
    <div class="container">
      <choose-login v-if="loginAs === ''" @pickLogin="loginAs = $event" />
      <as-admin v-if="loginAs === 'Admin'" @back="loginAs = ''" />
      <as-guest v-else-if="loginAs === 'Tamu'" @back="loginAs = ''" />
    </div>
  </div>
</template>

<style lang="less" scoped>
#login-wrapper {
  background-color: #FAFAFA;
  min-height: 100vh;
}
</style>

<script>
import ChooseLogin from '@/components/ChooseLogin'
import AsAdmin from '@/components/AsAdmin'
import AsGuest from '@/components/AsGuest'
export default {
  components: {
    ChooseLogin,
    AsAdmin,
    AsGuest
  },
  data () {
    return {
      loginAs: ''
    }
  }
}
</script>
