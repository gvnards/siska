<template>
  <div id="atur-wrapper">
    <AddDataPopup :isSuccess="popup.isSuccess" />
    <DeleteDataPopup :isSuccess="popup.isSuccess" />
    <EditDataPopup :isSuccess="popup.isSuccess" />
    <AddGajiPegawaiModal :onModal="modal.show" @onShowPopup="popup.isSuccess = $event; getData()" />
    <EditGajiPegawaiModal :onModal="modal.show" :dataEdit="dataEdit" @onShowPopup="popup.isSuccess = $event; getData()" />
    <AddPotonganModal :onModal="modal.show" @onShowPopup="popup.isSuccess = $event; getData()" />
    <EditPotonganModal :onModal="modal.show" :dataEdit="dataEdit" @onShowPopup="popup.isSuccess = $event; getData()" />
    <EditProfilPegawaiModal v-if="menu.active === 'Profil Pegawai'" :onModal="modal.show" :dataEdit="dataEdit" @onShowPopup="popup.isSuccess = $event; getPegawai()" />
    <AddTunjanganModal :onModal="modal.show" @onShowPopup="popup.isSuccess = $event; getData()" />
    <ImportModal :onModal="modal.show" @onShowPopup="popup.isSuccess = $event; getData()" />
    <div class="header-title">
      <p>{{ $store.state.menu.active }} <span>Pengaturan Data</span></p>
      <button :disabled="menu.active === 'Profil Pegawai'" @click="modal.show = true" class="btn btn-sm btn-primary btn-add-data" :style="menu.active === 'Profil Pegawai' ? 'cursor: not-allowed !important;':''" data-toggle="modal" :data-target="`#modalAdd${menu.active.split(' ').join('')}`">Tambah</button>
      <!-- Import Button -->
      <button v-if="menu.active === 'Gaji Pegawai'" class="btn btn-sm btn-success btn-add-data" data-toggle="modal" :data-target="`#modalImport`" @click="modal.show = true">Impor dari Excel</button>
      <!-- End Import Button -->
    </div>
    <div class="mTabs">
      <div class="tabs-head-wrapper">
        <div class="custom-tabs">
          <div class="mTabs-item text-center" :class="item === menu.active ? 'active' : ''" v-for="(item, index) in menu.list" :key="index" @click="menu.active = item">
            {{ item }}
          </div>
        </div>
        <!-- <div class="custom-filter-search">
          <div class="form-group">
            <input type="text" class="form-control" id="search" v-model="search.text" placeholder="Pencarian...">
          </div>
        </div> -->
      </div>
      <div class="table-wrapper">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col" class="text-center">No</th>
              <th scope="col" class="text-center">
                <span v-if="menu.active === 'Gaji Pegawai'">Golongan</span>
                <span v-else-if="menu.active === 'Potongan' || menu.active === 'Tunjangan'">Nama {{ menu.active }}</span>
                <span v-else-if="menu.active === 'Profil Pegawai'">NIP</span>
              </th>
              <th scope="col" class="text-center" v-if="menu.active === 'Gaji Pegawai'">Masa Kerja</th>
              <th scope="col" class="text-center">
                <span v-if="menu.active === 'Gaji Pegawai'">Gaji Pokok</span>
                <span v-else-if="menu.active === 'Potongan' || menu.active === 'Tunjangan'">{{ menu.active }}</span>
                <span v-else-if="menu.active === 'Profil Pegawai'">Nama</span>
              </th>
              <th scope="col" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in datas" :key="index">
              <th scope="row" class="text-center" style="vertical-align: middle;">{{ index + 1 }}</th>
              <td class="text-center" style="vertical-align: middle;">
                <span v-if="menu.active === 'Gaji Pegawai'">{{ item.golongan }}</span>
                <span v-else-if="menu.active === 'Potongan' || menu.active === 'Tunjangan'">{{ item.nama }}</span>
                <span v-else-if="menu.active === 'Profil Pegawai'">{{ item.nip }}</span>
              </td>
              <td class="text-center" style="vertical-align: middle;" v-if="menu.active === 'Gaji Pegawai'">{{ item.masa_kerja }} tahun</td>
              <td class="text-center" style="vertical-align: middle;">
                <span v-if="menu.active === 'Gaji Pegawai'">Rp {{ item.gaji | convertRp }}</span>
                <span v-else-if="menu.active === 'Potongan'">
                  <span v-if="item.jenis === '%'">{{ item.potongan }} %</span>
                  <span v-if="item.jenis === 'Rp'">Rp {{ item.potongan | convertRp }}</span>
                </span>
                <span v-else-if="menu.active === 'Tunjangan'">
                  <span v-if="item.jenis === '%'">{{ item.tunjangan }} %</span>
                  <span v-if="item.jenis === 'Rp'">Rp {{ item.tunjangan | convertRp }}</span>
                </span>
                <span v-else-if="menu.active === 'Profil Pegawai'">{{ item.nama }}</span>
              </td>
              <td class="text-center" style="vertical-align: middle;">
                <button class="btn btn-sm btn-info" @click="onDataEdit(item)" data-toggle="modal" :data-target="`#modalEdit${menu.active.split(' ').join('')}`"><img src="../assets/edit.png" alt="Ubah Slip Gaji" srcset=""></button>
                <button class="btn btn-sm btn-danger" @click="deleteData(item.id)" v-if="menu.active !== 'Profil Pegawai'"><img src="../assets/remove.png" alt="Hapus Slip Gaji" srcset=""></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
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
#atur-wrapper {
  margin-top: 20px;
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
  th[scope="row"] {
    font-size: 14px;
  }
  tr {
    td {
      font-size: 14px;
      font-weight: 500;
    }
  }
}
</style>

<script>
import $ from 'jquery'
import axios from 'axios'
import AddGajiPegawaiModal from '@/components/modals/AddGajiPegawai'
import EditGajiPegawaiModal from '@/components/modals/EditGajiPegawai'
import AddPotonganModal from '@/components/modals/AddPotongan'
import EditPotonganModal from '@/components/modals/EditPotongan'
import AddDataPopup from '@/components/modals/popups/AddDataPopup'
import DeleteDataPopup from '@/components/modals/popups/DeleteDataPopup'
import EditDataPopup from '@/components/modals/popups/EditDataPopup'
import EditProfilPegawaiModal from '@/components/modals/EditProfilPegawai'
import AddTunjanganModal from '@/components/modals/AddTunjangan'
import ImportModal from '@/components/modals/Import'
export default {
  components: {
    AddGajiPegawaiModal,
    EditGajiPegawaiModal,
    AddPotonganModal,
    EditPotonganModal,
    AddDataPopup,
    DeleteDataPopup,
    EditDataPopup,
    EditProfilPegawaiModal,
    AddTunjanganModal,
    ImportModal
  },
  watch: {
    'modal.show' (val) {
      if (val) {
        setTimeout(() => {
          this.modal.show = false
        }, 100)
      }
    },
    'menu.active' (val) {
      if (val === 'Profil Pegawai') {
        this.getPegawai()
      } else {
        this.getData()
      }
    }
  },
  data () {
    return {
      search: {
        text: ''
      },
      popup: {
        isSuccess: Boolean
      },
      modal: {
        show: false
      },
      menu: {
        active: 'Profil Pegawai',
        list: ['Profil Pegawai', 'Gaji Pegawai', 'Tunjangan', 'Potongan']
      },
      datas: [],
      dataEdit: {}
    }
  },
  methods: {
    onDataEdit (data) {
      if (this.menu.active === 'Gaji Pegawai') {
        let temp = data.golongan.split('/')
        this.dataEdit = {
          id: data.id,
          gol: temp[0],
          tingkat: temp[1],
          masaKerja: data.masa_kerja,
          gaji: data.gaji
        }
      } else if (this.menu.active === 'Potongan') {
        this.dataEdit = {
          id: data.id,
          nama: data.nama,
          jenis: data.jenis,
          potongan: data.potongan
        }
      } else if (this.menu.active === 'Profil Pegawai') {
        this.dataEdit = data
      }
      this.modal.show = true
    },
    getData () {
      let onGetString = `Get${this.menu.active.split(' ')[0]}`
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: onGetString
        }
      }).then(res => {
        this.datas = res.data
      })
    },
    getPegawai () {
      axios({
        url: 'https://server.cuti.bkpsdmsitubondo.id/',
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetPegawaiAdmin',
          opd_id: 5
        }
      }).then(res => {
        this.datas = res.data.pegawai
        this.datas = this.datas.sort((a, b) => (a.nama > b.nama) ? 1 : -1)
        let nip = ''
        let kawin = ''
        this.datas.forEach(el => {
          nip += `${el.nip},`
          kawin += el.JENIS_KAWIN_NAMA.toLowerCase() === 'menikah' ? '1,' : '0,'
        })
        nip = nip.slice(0, -1)
        kawin = kawin.slice(0, -1)
        return axios({
          url: `${this.$store.state.BASED_URL}siska_server/index.php`,
          method: 'POST',
          data: {
            onPost: 'InsertProfil',
            nips: nip,
            kawins: kawin
          }
        })
      })
    },
    deleteData (id) {
      let onPostString = `Del${this.menu.active.split(' ')[0]}`
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: onPostString,
          id: id
        }
      }).then(res => {
        this.popup.isSuccess = res.data.callback
        $('#showModalDeleteDataPopup').trigger('click')
        return this.getData()
      }).catch(_ => {
        this.popup.isSuccess = false
        $('#showModalDeleteDataPopup').trigger('click')
        return this.getData()
      })
    }
  },
  filters: {
    convertRp (value) {
      if (!value) return ''
      let temp = ''
      let count = 0
      for (let i = value.toString().length - 1; i >= 0; i--) {
        count++
        temp = `${value.toString()[i]}${temp}`
        if (count % 3 === 0) {
          temp = `.${temp}`
          count = 0
        }
      }
      if (temp[0] === '.') {
        temp = temp.slice(1)
      }
      return temp
    }
  },
  created () {
    this.getPegawai()
  }
}
</script>
