<template>
  <div id="slipgaji-wrapper">
    <AddDataPopup :isSuccess="popup.isSuccess" />
    <EditDataPopup :isSuccess="popup.isSuccess" />
    <AddSlipGajiModal :onModal="modal.show" @onShowPopup="popup.isSuccess = $event;" @refreshData="getSlipData()" />
    <EditSlipGajiModal :onModal="modal.show" @onShowPopup="popup.isSuccess = $event;" :dataEdit="dataEdit" @refreshData="getSlipData()" />
    <div class="header-title">
      <p>{{ $store.state.menu.active }} <span>Slip Gaji Pegawai</span></p>
      <button @click="modal.show = true" class="btn btn-sm btn-primary btn-add-data" data-toggle="modal" data-target="#modalAddSlipGaji">Tambah</button>
    </div>
    <div class="mTabs">
      <div class="tabs-head-wrapper">
        <div class="custom-tabs">
          <div class="mTabs-item text-center" :class="item === menu.active ? 'active' : ''" v-for="(item, index) in menu.list" :key="index" @click="menu.active = item">
            {{ item }}
          </div>
        </div>
        <div class="custom-filter-search">
          <div class="form-group">
            <input type="text" class="form-control" id="search" v-model="search.text" placeholder="Pencarian...">
          </div>
        </div>
      </div>
      <div class="table-wrapper">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col" class="text-center">No</th>
              <th scope="col" class="text-center">NIP</th>
              <th scope="col" class="text-center">Nama</th>
              <th scope="col" class="text-center">Bulan</th>
              <th scope="col" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in dataSlipPegawai" :key="index">
              <th scope="row" class="text-center" style="vertical-align: middle;">{{ index + 1 }}</th>
              <td class="text-center" style="vertical-align: middle;">{{ item.nip }}</td>
              <td class="text-center" style="vertical-align: middle;">{{ item.nama }}</td>
              <td class="text-center" style="vertical-align: middle;">{{ item.tanggal_slip | convertTanggal }}</td>
              <td class="text-center" style="vertical-align: middle;">
                <button class="btn btn-sm btn-success" @click="toUrl(item)"><img src="../assets/download.png" alt="Unduh Slip Gaji" srcset=""></button>
                <button class="btn btn-sm btn-info" @click="editSlip(item)" data-toggle="modal" data-target="#modalEditSlipGaji"><img src="../assets/edit.png" alt="Ubah Slip Gaji" srcset=""></button>
                <button class="btn btn-sm btn-danger" @click="delSlip(item)"><img src="../assets/remove.png" alt="Hapus Slip Gaji" srcset=""></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style lang="less" scope>
#slipgaji-wrapper {
  td {
    button {
      max-width: 14px;
      img {
        margin-left: -8px;
        position: relative;
        display: block;
        width: 16px;
        height: 16px;
      }
    }
  }
  margin-top: 20px;
  .btn {
    padding-left: 20px;
    padding-right: 20px;
    font-size: 14px;
    font-weight: 500;
    &-add-data {
      padding: 0px 10px;
      margin-left: 10px;
      height: 30px;
    }
  }
  .header-title {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    min-width: 600px;
    p {
      margin: 0;
      color: black;
      font-size: 16px;
      font-weight: 600;
      span {
        font-size: 12px;
        font-weight: 400;
      }
    }
  }
  .mTabs {
    position: relative;
    .tabs-head-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      min-width: 600px;
      flex-wrap: wrap;
      .custom-filter-search {
        position: relative;
        .form-group {
          max-width: 200px;
          input {
            text-overflow: ellipsis;
          }
        }
      }
      .mTabs-item {
        margin-right: 8px;
        cursor: pointer;
        color: #4D4D4D;
        font-size: 16px;
        font-weight: 600;
        padding: 0px 4px 4px 4px;
        border-bottom: 3px solid transparent;
        display: inline-block;
        &.active {
          color: black;
          border-bottom-color: black;
        }
      }
    }
  }
  table {
    min-width: 600px;
  }
}
</style>

<script>
import AddSlipGajiModal from '@/components/modals/AddSlipGaji'
import AddDataPopup from '@/components/modals/popups/AddDataPopup'
import EditSlipGajiModal from '@/components/modals/EditSlipGaji'
import EditDataPopup from '@/components/modals/popups/EditDataPopup'
import axios from 'axios'
export default {
  components: {
    AddSlipGajiModal,
    AddDataPopup,
    EditSlipGajiModal,
    EditDataPopup
  },
  watch: {
    'modal.show' (val) {
      if (val) {
        setTimeout(() => {
          this.modal.show = false
        }, 100)
      }
    }
  },
  data () {
    return {
      search: {
        text: ''
      },
      filter: {
        year: ''
      },
      dataEdit: {},
      popup: {
        isSuccess: Boolean
      },
      modal: {
        show: false
      },
      menu: {
        active: 'Gaji Pokok',
        list: ['Gaji Pokok']
      },
      dataSlip: []
    }
  },
  computed: {
    dataSlipPegawai () {
      if (this.search.text === '') return this.dataSlip
      let tempDataSlip = [...this.dataSlip]
      return tempDataSlip.filter(el => el.nip.includes(this.search.text) || el.nama.toLowerCase().includes(this.search.text.toLowerCase()))
    }
  },
  methods: {
    editSlip (item) {
      this.dataEdit = item
      this.modal.show = true
    },
    delSlip (data) {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'DelSlipGaji',
          nip: data.nip,
          tanggal: data.tanggal_slip,
          jenis: data.id_jenis_slip
        }
      }).then(res => {
        return this.getSlipData()
      })
    },
    toUrl (data) {
      window.open(`${this.$store.state.BASED_URL}siska_slip/?idSlip=${data.id}`)
    },
    getPegawai () {
      axios({
        url: 'https://server.cuti.bkpsdmsitubondo.id/',
        method: 'GET',
        params: {
          onGet: 'GetPegawaiAdmin',
          opd_id: 5
        }
      }).then(res => {
        this.$store.commit('SET_DATA_PEGAWAI', res.data.pegawai)
      })
    },
    getSlipData () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          onGet: 'GetSlipGaji'
        }
      }).then(res => {
        let data = []
        res.data.forEach(eachData => {
          let flag = false
          for (let i = 0; i < data.length; i++) {
            if (data[i].nip === eachData.nip && data[i].tanggal_slip === eachData.tanggal_slip) {
              flag = true
            }
          }
          if (!flag) {
            data.push(eachData)
          }
        })
        for (let i = 0; i < data.length - 1; i++) {
          for (let j = i + 1; j < data.length; j++) {
            if (new Date(data[i].tanggal_slip).getTime() > new Date(data[j].tanggal_slip).getTime()) {
              let temp = data[i]
              data[i] = data[j]
              data[j] = temp
            }
          }
        }
        this.dataSlip = data
      })
    }
  },
  filters: {
    convertTanggal (value) {
      if (!value) return ''
      let tempTanggal = value.split('-')
      let listMonth = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember']
      return `${listMonth[parseInt(tempTanggal[1]) - 1]} ${tempTanggal[0]}`
    }
  },
  created () {
    this.getPegawai()
    this.getSlipData()
  }
}
</script>
