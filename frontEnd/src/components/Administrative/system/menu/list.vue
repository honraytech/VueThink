<template>
	<div>
		<div class="m-b-20">
  		<router-link class="btn-link-large add-btn" to="add">
  		  <i class="el-icon-plus"></i>&nbsp;&nbsp;添加菜单
  		</router-link>
		</div>
		<el-table
		:data="tableData"
		style="width: 100%"
		@selection-change="selectItem">
			<el-table-column
			type="selection"
			:context="_self"
			width="50">
			</el-table-column>
			<el-table-column
			prop="p_title"
			label="上级菜单"
			width="150">
			</el-table-column>
			<el-table-column
			prop="title"
			label="标题">
			</el-table-column>
		<!-- <el-table-column
		prop="menu_type"
		label="类型"
		width="200">
		</el-table-column> -->
			<el-table-column
			label="状态"
			width="100">
				<template slot-scope="scope">
					{{ scope.row.status | status}}
				</template>
			</el-table-column>
			<el-table-column
			label="操作"
			width="200">
				<template slot-scope="scope">
					<router-link :to="{ name: 'menuEdit', params: { id: scope.row.id }}">
						<el-button size="small" type="primary">编辑</el-button>
					</router-link>
						<el-button size="small" type="danger" @click="confirmDelete(scope.row)">删除</el-button>
				</template>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :type="'menus'"></btnGroup>
		</div>
	</div>
</template>

<script>
  import btnGroup from '../../../Common/btn-group.vue'
  import http from '../../../../assets/js/http'

  export default {
    data() {
      return {
        tableData: [],
        multipleSelection: []
      }
    },
    methods: {
      selectItem(val) {
        this.multipleSelection = val
      },
      confirmDelete(item) {
        this.$confirm('确认删除该菜单?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _g.openGlobalLoading()
          this.apiDelete('admin/menus/', item.id).then((res) => {
            _g.closeGlobalLoading()
            this.handelResponse(res, (data) => {
              _g.toastMsg('success', '删除成功')
              setTimeout(() => {
                _g.shallowRefresh(this.$route.name)
              }, 1500)
            })
          })
        }).catch(() => {
          // handel error
        })
      }
    },
    created() {
      this.apiGet('admin/menus').then((res) => {
        this.handelResponse(res, (data) => {
          this.tableData = data
        })
      })
    },
    computed: {
      addShow() {
        return _g.getHasRule('menus-save')
      },
      editShow() {
        return _g.getHasRule('menus-update')
      },
      deleteShow() {
        return _g.getHasRule('menus-delete')
      }
    },
    components: {
      btnGroup
    },
    mixins: [http]
  }
</script>