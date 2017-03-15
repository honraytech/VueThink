const actions = {
  showLeftMenu ({ commit }, status) {
    commit('showLeftMenu', status)
  },
  showLoading ({ commit }, status) {
    commit('showLoading', status)
  },
  setMenus({ commit }, menus) {
    commit('setMenus', menus)
  },
  setRules({ commit }, rules) {
    commit('setRules', rules)
  },
  setUsers({ commit }, users) {
    commit('setUsers', users)
  },
  setUserGroups({ commit }, userGroups) {
    commit('setUserGroups', userGroups)
  },
  setOrganizes({ commit }, organizes) {
    commit('setOrganizes', organizes)
  }
}

export default actions
