const listMixin = {
  data() {
    return {
      currentPage: null,          // 分页当前页
      keywords: '',               // 关键字搜索
      multipleSelection: [],      // 列表当前已勾选项
      limit: 15,                  // 每页数据数目
      dataCount: 0
    }
  },
  methods: {
    selectItem(val) {
      this.multipleSelection = val
    },
    getCurrentPage() {
      let data = this.$route.query
      if (data) {
        if (data.page) {
          this.currentPage = parseInt(data.page)
        } else {
          this.currentPage = 1
        }
      }
    },
    getKeywords() {
      let data = this.$route.query
      if (data) {
        if (data.keywords) {
          this.keywords = data.keywords
        } else {
          this.keywords = ''
        }
      }
    }
  }
}

export default listMixin
