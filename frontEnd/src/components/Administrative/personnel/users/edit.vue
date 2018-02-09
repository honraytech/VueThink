<template>
	<div class="m-l-50 m-t-30 w-500">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="用户名" prop="username">
				<el-input v-model.trim="form.username" class="h-40 w-200" :maxlength=12 :disabled="true"></el-input>
			</el-form-item>
			<el-form-item label="密码">
				<el-input v-model.trim="password" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="真实姓名" prop="realname">
				<el-input v-model.trim="form.realname" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="所属组织架构" prop="structure_id">
				<el-select v-model="form.structure_id" placeholder="请选择组织架构" class="w-200">
					<el-option v-for="item in orgsOptions" :label="item.title" :value="item.id" :key="item.id"></el-option>
				</el-select>
			</el-form-item>
			<el-form-item label="备注">
				<el-input v-model.trim="form.remark" class="h-40 w-200"></el-input>
			</el-form-item>
			<el-form-item label="用户组">
				<el-checkbox-group v-model="selectedGroups">
					<el-checkbox v-for="item in groupOptions" :label="item.else" class="form-checkbox" :key="item.id"></el-checkbox>
				</el-checkbox-group>
			</el-form-item>
			<el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading">提交</el-button>
				<el-button @click="goback()">返回</el-button>
			</el-form-item>
		</el-form>
	</div>
</template>
<style>
	.form-checkbox:first-child{
		margin-left: 15px;
	}
</style>
<script>
  import http from '../../../../assets/js/http'
  import fomrMixin from '../../../../assets/js/form_com'

  export default {
    data() {
      return {
        isLoading: false,
        id: null,
        form: {
          username: '',
          realname: '',
          structure_id: null,
          remark: '',
          groups: []
        },
        password: '',
        orgsOptions: [],
        groupOptions: [],
        selectedGroups: [],
        selectedIds: [],
        rules: {
          username: [
            { required: true, message: '请输入用户名' }
          ],
          realname: [
            { required: true, message: '请输入真实姓名' }
          ],
          structure_id: [
            { required: true, message: '请选择用户所属组织架构' }
          ]
        }
      }
    },
    methods: {
      selectCheckbox() {
        let temp = false
        _(this.groupOptions).forEach((res) => {
          if (this.selectedGroups.toString().indexOf(res.else) > -1) {
            this.selectedIds.push(res.id)
          }
        })
        if (this.selectedIds.length) {
          this.form.groups = _.cloneDeep(this.selectedIds)
          temp = true
        }
        this.selectedIds = []
        return temp
      },
      add() {
        if (!this.selectCheckbox()) {
          _g.toastMsg('warning', '请选择用户组')
          return
        }
        this.$refs.form.validate((pass) => {
          if (pass) {
            this.isLoading = true
            if (this.password) {
              this.form.password = this.password
            }
            this.apiPut('admin/users/', this.id, this.form).then((res) => {
              this.handelResponse(res, (data) => {
                this.isLoading = false
                _g.toastMsg('success', '添加成功')
                _g.clearVuex('setUsers')
                setTimeout(() => {
                  this.goback()
                }, 1500)
              }, () => {
                this.isLoading = false
              })
            })
          }
        })
      },
      getAllGroups() {
        return new Promise((resolve, reject) => {
          let data = store.state.userGroups
          if (data && data.length) {
            resolve(data)
          } else {
            this.apiGet('admin/groups').then((res) => {
              this.handelResponse(res, (data) => {
                resolve(data)
              })
            })
          }
        })
      },
      getAllOrgs() {
        this.apiGet('admin/structures').then((res) => {
          this.handelResponse(res, (data) => {
            this.orgsOptions = data
          })
        })
      },
      async getCompleteData() {
        this.getAllOrgs()
        this.groupOptions = await this.getAllGroups()
        this.apiGet('admin/users/' + this.id).then((res) => {
          this.handelResponse(res, (data) => {
            this.form.username = data.username
            this.form.realname = data.realname
            this.form.structure_id = data.structure_id
            this.form.remark = data.remark
            _(data.groups).forEach((res1) => {
              _(this.groupOptions).forEach((res2) => {
                if (res1.title == res2.else) {
                  this.selectedGroups.push(res1.title)
                }
              })
            })
          })
        })
      }
    },
    created() {
      this.id = this.$route.params.id
      this.getCompleteData()
    },
    mixins: [http, fomrMixin]
  }
</script>