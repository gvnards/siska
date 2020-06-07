<template>
  <div id="MainApp">
    <Menu />
    <Content>
      <Dasbor v-if="$store.state.menu.active === 'Dasbor'" />
      <SlipGaji v-if="$store.state.menu.active === 'Slip Gaji'" />
      <Atur v-else-if="$store.state.menu.active === 'Atur'" />
    </Content>
  </div>
</template>

<style lang="less" scoped>
#MainApp {
  display: flex;
}
</style>

<script>
import Menu from '@/components/Menu'
import Content from '@/components/Content'
import Dasbor from '@/components/Dasbor'
import SlipGaji from '@/components/SlipGaji'
import Atur from '@/components/Atur'
export default {
  components: {
    Menu,
    Content,
    Dasbor,
    SlipGaji,
    Atur
  },
  data () {
    return {
      //
    }
  }
}
</script>
