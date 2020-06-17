<template>
  <!-- Modal -->
  <div class="modal fade" id="modalEditProfilPegawai" tabindex="-1" role="dialog" aria-labelledby="modalEditProfilPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditProfilPegawaiLabel">Edit Profil Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mTabs">
            <div class="tabs-head-wrapper">
              <div class="custom-tabs">
                <div class="mTabs-item text-center" :class="item === tabs.active ? 'active' : ''" v-for="(item, index) in tabs.list" :key="index" @click="dataEdit.JENIS_KAWIN_NAMA.toLowerCase() === 'belum kawin' ? tabs.active = tabs.list[0] : tabs.active = item" :style="dataEdit.JENIS_KAWIN_NAMA.toLowerCase() === 'belum kawin' && item.toLowerCase().includes('kawin') ? 'cursor: not-allowed !important;' : ''">
                  {{ item }}
                </div>
              </div>
            </div>
            <div class="mTabs-section-container" v-if="tabs.active === 'Data Pegawai'">
              <div class="form-group" v-for="(item, index) in ['nip', 'nama', 'JENIS_KELAMIN', 'JENIS_KAWIN_NAMA', 'nama_jabatan']" :key="index">
                <input v-if="item === 'JENIS_KELAMIN'" type="text" class="form-control" disabled :placeholder="dataEdit[item] === 'M' ? 'Laki-laki' : 'Perempuan'">
                <input v-else type="text" class="form-control" disabled :placeholder="dataEdit[item]">
              </div>
            </div>
            <div class="mTabs-section-container" v-else-if="tabs.active === 'Data Perkawinan'">
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="isPasanganASN" v-model="dataKeluarga.is_pasangan_pns">
                  <label class="custom-control-label" for="isPasanganASN">Suami / Istri adalah seorang ASN</label>
                </div>
              </div>
              <div class="form-group" v-if="dataKeluarga.is_pasangan_pns">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="isGreaterThan" v-model="dataKeluarga.is_greater_than">
                  <label class="custom-control-label" for="isGreaterThan">Gaji pokok suami / istri lebih besar</label>
                </div>
              </div>
              <div class="form-group">
                <label for="jumlahAnak">Jumlah Anak<div class="help bg-info text-white">?</div></label>
                <input type="number" class="form-control" id="jumlahAnak" min="0" v-model="dataKeluarga.jumlah_anak">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalEditProfil">Tutup</button>
          <button type="button" class="btn btn-primary" @click="updateProfil()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
.help {
  width: 14px;
  height: 14px;
  border-radius: 50%;
  font-size: 11px;
  font-weight: 600;
  text-align: center;
  position: absolute;
  top: 0;
  right: -18px;
  cursor: pointer;
  &:hover::after {
    content: "Jumlah anak yang berhak";
    position: absolute;
    min-width: 100%;
    box-sizing: border-box;
    background-color: rgb(23, 162, 184);
    padding: 2px 6px;
    left: 18px;
    top: -4px;
    border-radius: 4px;
    white-space: nowrap;
    font-weight: 400;
  }
}
label {
  position: relative;
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
  .mTabs-section-container {
    padding: 10px 0px;
    box-sizing: border-box;
  }
}
</style>

<script>
import $ from 'jquery'
import axios from 'axios'
export default {
  props: {
    onModal: Boolean,
    dataEdit: Object
  },
  watch: {
    onModal (val) {
      if (val) {
        this.tabs.active = 'Data Pegawai'
      }
    },
    'tabs.active' (val) {
      if (val === 'Data Perkawinan') {
        this.getProfil()
      }
    },
    dataKeluarga (val) {
      val.is_greater_than = parseInt(val.is_greater_than)
      val.is_pasangan_pns = parseInt(val.is_pasangan_pns)
    }
  },
  data () {
    return {
      tabs: {
        active: 'Data Pegawai',
        list: ['Data Pegawai', 'Data Perkawinan']
      },
      dataKeluarga: Object
    }
  },
  methods: {
    getProfil () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetProfil',
          nip: this.dataEdit.nip
        }
      }).then(res => {
        this.dataKeluarga = res.data
      })
    },
    updateProfil () {
      this.dataKeluarga.is_pasangan_pns = Number(this.dataKeluarga.is_pasangan_pns)
      this.dataKeluarga.is_greater_than = Number(this.dataKeluarga.is_greater_than)
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'EditProfil',
          id: this.dataKeluarga.id,
          status_perkawinan: this.dataEdit.JENIS_KAWIN_NAMA.toLowerCase() === 'menikah',
          is_pasangan_pns: this.dataKeluarga.is_pasangan_pns,
          is_greater_than: this.dataKeluarga.is_greater_than,
          jumlah_anak: this.dataKeluarga.jumlah_anak
        }
      }).then(res => {
        $('#closeModalEditProfil').trigger('click')
        this.$emit('onShowPopup', Boolean(Number(res.data.callback)))
        $('#showModalEditDataPopup').trigger('click')
      }).catch(_ => {
        $('#closeModalEditProfil').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalEditDataPopup').trigger('click')
      })
    }
  }
}
</script>
