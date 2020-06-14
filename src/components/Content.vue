<template>
  <div id="Content" :class="$store.state.shrinkMainMenu ? '':'small-menu'">
    <ContentHeader />
    <slot></slot>
  </div>
</template>

<style lang="less" scoped>
#Content {
  min-width: calc(100vw - 240px);
  &.small-menu {
    min-width: calc(100vw - 80px);
  }
  min-height: 100vh;
  max-height: 100vh;
  overflow: auto;
  background-color: #ECF0F5;
  padding: 20px 40px;
  box-sizing: border-box;
}
</style>

<script>
import ContentHeader from '@/components/ContentHeader'
export default {
  components: {
    ContentHeader
  }
}
</script>
