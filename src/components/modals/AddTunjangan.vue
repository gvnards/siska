<template>
  <!-- Modal -->
  <div class="modal fade" id="modalAddTunjangan" tabindex="-1" role="dialog" aria-labelledby="modalAddTunjanganLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddTunjanganLabel">Tambah Data Tunjangan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="item" v-for="(item, index) in dataTunjangan" :key="index">
            <div class="form-group">
              <input v-model="item.nama" type="text" class="form-control" placeholder="Nama Tunjangan">
            </div>
            <div class="form-group">
              <select class="form-control" v-model="item.jenis">
                <option disabled selected>Jenis Tunjangan</option>
                <option v-for="(item, index) in ['%', 'Rp']" :key="index">{{ item }}</option>
              </select>
            </div>
            <div class="form-group">
              <input v-model="item.tunjangan" :step="item.jenis === '%' ? '0.01': '1'" type="number" class="form-control" placeholder="Masukkan Tunjangan">
            </div>
            <img @click="delData(index)" src="./../../assets/remove_red.png" alt="" srcset="">
          </div>
          <div class="btn btn-sm btn-success btn-block" style="font-size: 20px; padding: 2px; height: 18px; overflow: hidden;"><p style="margin-top: -8px;" @click="dataTunjangan.push({nama: '', jenis: 'Jenis Tunjangan', tunjangan: Number})">+</p></div>
          <small class="text-danger">* Selain tunjangan jabatan dan keluarga</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalAddTunjangan">Tutup</button>
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
  img {
    margin: 0;
    width: 20px;
    cursor: pointer;
    margin-top: -12px;
  }
  .form-group {
    margin-left: 8px;
    margin-right: 8px;
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
      this.dataTunjangan = []
    }
  },
  data () {
    return {
      dataTunjangan: []
    }
  },
  methods: {
    delData (index) {
      this.dataTunjangan.splice(index, 1)
    },
    addData () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'InsertTunjangan',
          tunjangans: this.dataTunjangan
        }
      }).then(res => {
        $('#closeModalAddTunjangan').trigger('click')
        this.$emit('onShowPopup', res.data.callback)
        $('#showModalAddDataPopup').trigger('click')
      }).catch(_ => {
        $('#closeModalAddTunjangan').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalAddDataPopup').trigger('click')
      })
    }
  }
}
</script>
