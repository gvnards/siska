<template>
  <!-- Modal -->
  <div class="modal fade" id="modalAddGajiPegawai" tabindex="-1" role="dialog" aria-labelledby="modalAddGajiPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddGajiPegawaiLabel">Tambah Data Gaji Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="item" v-for="(item, index) in dataGaji" :key="index">
            <div>
              <div class="item">
                <div class="form-group">
                  <select class="form-control" v-model="item.gol">
                    <option disabled selected>Pilih Golongan</option>
                    <option v-for="(item, index) in golongan.gol" :key="index">{{ item }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-control" v-model="item.tingkat">
                    <option disabled selected>Pilih Tingkatan</option>
                    <option v-for="(item, index) in golongan.abj" :key="index">{{ item }}</option>
                  </select>
                </div>
              </div>
              <div class="item">
                <div class="form-group">
                  <input v-model="item.masaKerja" type="number" class="form-control" placeholder="Masa Kerja (tahun)">
                </div>
                <div class="form-group">
                  <input v-model="item.gaji" type="number" class="form-control" placeholder="Masukkan Gaji">
                </div>
              </div>
            </div>
            <img @click="delData(index)" src="./../../assets/remove_red.png" alt="" srcset="">
          </div>
          <div class="btn btn-sm btn-success btn-block" style="font-size: 20px; padding: 2px; height: 18px; overflow: hidden;"><p style="margin-top: -8px;" @click="dataGaji.push({gol: 'Pilih Golongan', tingkat: 'Pilih Tingkatan', masaKerja: Number, gaji: Number})">+</p></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalAddGajiPegawai">Tutup</button>
          <button type="button" class="btn btn-primary" @click="addData()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>
.form-control {
  font-size: 14px;
  font-weight: 400;
}
.item {
  display: flex;
  position: relative;
  justify-content: space-between;
  align-items: center;
  overflow: auto;
  img {
    margin: 0;
    min-width: 24px;
    max-width: 24px;
    cursor: pointer;
    margin-top: -12px;
    margin-left: 20px;
  }
  select {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 200px;
    max-width: 200px;
  }
}
.btn {
  font-size: 14px;
  font-weight: 500;
}
</style>

<script>
import $ from 'jquery'
import axios from 'axios'
export default {
  props: {
    onModal: Boolean
  },
  watch: {
    onModal (val) {
      this.dataGaji = []
      // eslint-disable-next-line
      // let gapok = [2688500,2688500,2773200,2773200,2860500,2860500,]
      // gapok.forEach((item, index) => {
      //   this.dataGaji.push(
      //     {
      //       gol: 'III',
      //       tingkat: 'b',
      //       masaKerja: index,
      //       gaji: item
      //     }
      //   )
      // })
    }
  },
  data () {
    return {
      golongan: {
        gol: ['I', 'II', 'III', 'IV'],
        abj: ['a', 'b', 'c', 'd', 'e']
      },
      dataGaji: []
    }
  },
  methods: {
    delData (index) {
      this.dataGaji.splice(index, 1)
    },
    addData () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'InsertGaji',
          gajis: this.dataGaji
        }
      }).then(res => {
        $('#closeModalAddGajiPegawai').trigger('click')
        this.$emit('onShowPopup', res.data.callback)
        $('#showModalAddDataPopup').trigger('click')
      }).catch(_ => {
        $('#closeModalAddGajiPegawai').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalAddDataPopup').trigger('click')
      })
    }
  }
}
</script>
