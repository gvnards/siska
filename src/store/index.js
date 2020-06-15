import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    shrinkMainMenu: true,
    pegawai: [],
    menu: {
      active: 'Dasbor'
    },
    account: {
      nama: 'Admin',
      nama_opd: 'Badan Kepegawaian dan Pengembangan Manusia',
      opd_id: '5',
      nama_jabatan: 'Admin'
    },
    BASED_URL: 'http://127.0.0.1/' // https://siska.bkpsdmsitubondo.id/ or http://127.0.0.1/
  },
  mutations: {
    SET_SHRINK_MAIN_MENU (state, value) {
      state.shrinkMainMenu = value
    },
    SET_MENU_ACTIVE (state, value) {
      state.menu.active = value
    },
    SET_DATA_PEGAWAI (state, value) {
      state.pegawai = value
    }
  },
  actions: {
  },
  modules: {
  }
})
