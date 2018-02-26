<template>
  <div>
    <el-menu ref="menu" mode="vertical" class="el-menu-vertical-demo" 
      router 
      background-color="#324057"
      :default-active="defaultActive"
      text-color="#fff"
      active-text-color="#e4ba55"
      @open="handleOpen">
      <el-submenu v-for="menu in menuData" :key="menu.id" :index="menu.id.toString()">
        <template slot="title">
          <i class="el-icon-menu"></i>
          <span>{{menu.title}}</span>
        </template>
        <el-menu-item-group>
          <el-menu-item v-for="item in menu.child" :key="item.id" :index="item.url">{{item.title}}</el-menu-item>
        </el-menu-item-group>
      </el-submenu>
    </el-menu>
  </div>
</template>

<script>
import _g from '@/assets/js/global'

export default {
  props: ['menuData', 'menu'],
  data() {
    const path = this.defaultOpends()
    return {
      actived: '54',
      defaultActive: path
    }
  },
  methods: {
    defaultOpends() {
      if (this.$route.path !== '/home/config/add') {
        const pathsArr = this.$route.path.split('/')
        const pathModule = ['', pathsArr[1], pathsArr[2]].join('/')
        const operation = pathsArr[3]
        if (operation !== 'list') {
          return pathModule + '/list'
        }
      }
      return this.$route.path
    },
    handleOpen(index, indexPath) {

    },
    routerChange(item) {
      // 与当前页面路由相等则刷新页面
      if (item.url != this.$route.path) {
        router.push(item.url)
      } else {
        _g.shallowRefresh(this.$route.name)
      }
    }
  }
}
</script>