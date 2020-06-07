<template>
  <!-- Modal -->
  <div class="modal fade" id="modalEditGajiPegawai" tabindex="-1" role="dialog" aria-labelledby="modalEditGajiPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditGajiPegawaiLabel">Rubah Data Gaji Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div v-for="(item, index) in dataGaji" :key="index">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalEditGajiPegawai">Tutup</button>
          <button type="button" class="btn btn-primary" @click="editData()">Simpan</button>
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
    onModal: Boolean,
    dataEdit: Object
  },
  watch: {
    onModal (val) {
      this.dataGaji = [
        {
          id: this.dataEdit.id,
          gol: this.dataEdit.gol,
          tingkat: this.dataEdit.tingkat,
          masaKerja: this.dataEdit.masaKerja,
          gaji: this.dataEdit.gaji
        }
      ]
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
    editData () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'EditGaji',
          gajis: this.dataGaji
        }
      }).then(res => {
        $('#closeModalEditGajiPegawai').trigger('click')
        this.$emit('onShowPopup', res.data.callback)
        $('#showModalEditDataPopup').trigger('click')
      }).catch(_ => {
        $('#closeModalEditGajiPegawai').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalEditDataPopup').trigger('click')
      })
    }
  }
}
</script>
