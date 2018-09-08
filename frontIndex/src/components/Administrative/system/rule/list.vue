<template>
	<div>
		<div class="m-b-20">
  		<router-link class="btn-link-large add-btn" to="add">
  		  <i class="el-icon-plus"></i>&nbsp;&nbsp;添加节点
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
			label="节点结构"
			width="150">
			</el-table-column>
			<el-table-column
			prop="title"
			label="显示名">
			</el-table-column>
  		<el-table-column
  		prop="name"
  		label="名称"
  		width="200">
  		</el-table-column>
			<el-table-column
			inline-template
			label="状态"
			width="100">
				<div>
					{{ row.status | status}}
				</div>
			</el-table-column>
			<el-table-column
			label="操作"
			width="200">
        <template scope="scope">
          <div>
            <span>
              <router-link :to="{ name: 'ruleEdit', params: { id: scope.row.id }}" class="btn-link edit-btn">
              编辑
              </router-link>
            </span>
            <span>
              <el-button
              size="small"
              type="danger"
              @click="confirmDelete(scope.row)">
              删除
              </el-button>
            </span>
          </div>
        </template>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :type="'rules'"></btnGroup>
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
        this.$confirm('确认删除该权限?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _g.openGlobalLoading()
          this.apiDelete('admin/rules/', item.id).then((res) => {
            _g.closeGlobalLoading()
            this.handelResponse(res, (data) => {
              _g.toastMsg('success', '删除成功')
              setTimeout(() => {
                _g.shallowRefresh(this.$route.name)
              }, 1500)
            })
          })
        }).catch(() => {
        // handle error
        })
      }
    },
    created() {
      this.apiGet('admin/rules').then((res) => {
        this.handelResponse(res, (data) => {
          this.tableData = data
        })
      })
    },
    computed: {
      addShow() {
        return _g.getHasRule('rules-save')
      },
      editShow() {
        return _g.getHasRule('rules-update')
      },
      deleteShow() {
        return _g.getHasRule('rules-delete')
      }
    },
    components: {
      btnGroup
    },
    mixins: [http]
  }
</script>