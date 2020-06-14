<template>
  <!-- Modal -->
  <div class="modal fade" id="modalEditTunjangan" tabindex="-1" role="dialog" aria-labelledby="modalEditTunjanganLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditTunjanganLabel">Edit Data Tunjangan</h5>
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
              <input v-model="item.tunjangan" step="0.01" type="number" class="form-control" placeholder="Masukkan Tunjangan">
            </div>
            <img @click="delData(index)" src="./../../assets/remove_red.png" alt="" srcset="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalEditTunjangan">Tutup</button>
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
    onModal: Boolean,
    dataEdit: Object
  },
  watch: {
    onModal (val) {
      this.dataTunjangan = [
        {
          id: this.dataEdit.id,
          nama: this.dataEdit.nama,
          jenis: this.dataEdit.jenis,
          tunjangan: this.dataEdit.tunjangan
        }
      ]
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
          onPost: 'EditTunjangan',
          tunjangans: this.dataTunjangan
        }
      }).then(res => {
        $('#closeModalEditTunjangan').trigger('click')
        this.$emit('onShowPopup', res.data.callback)
        $('#showModalEditDataPopup').trigger('click')
      }).catch(_ => {
        $('#closeModalEditTunjangan').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalEditDataPopup').trigger('click')
      })
    }
  }
}
</script>
