import router from '@/router/index.js'
const formMixin = {
  methods: {
    goback() {
      router.go(-1)
    }
  }
}

export default formMixin
