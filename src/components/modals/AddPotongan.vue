<template>
  <!-- Modal -->
  <div class="modal fade" id="modalAddPotongan" tabindex="-1" role="dialog" aria-labelledby="modalAddPotonganLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddPotonganLabel">Tambah Data Potongan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="item" v-for="(item, index) in dataPotongan" :key="index">
            <div class="form-group">
              <input v-model="item.nama" type="text" class="form-control" placeholder="Nama Potongan">
            </div>
            <div class="form-group">
              <select class="form-control" v-model="item.jenis">
                <option disabled selected>Jenis Potongan</option>
                <option v-for="(item, index) in ['%', 'Rp']" :key="index">{{ item }}</option>
              </select>
            </div>
            <div class="form-group">
              <input v-model="item.potongan" :step="item.jenis === '%' ? '0.01': '1'" type="number" class="form-control" placeholder="Masukkan Potongan">
            </div>
            <img @click="delData(index)" src="./../../assets/remove_red.png" alt="" srcset="">
          </div>
          <div class="btn btn-sm btn-success btn-block" style="font-size: 20px; padding: 2px; height: 18px; overflow: hidden;"><p style="margin-top: -8px;" @click="dataPotongan.push({nama: '', jenis: 'Jenis Potongan', potongan: Number})">+</p></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalAddPotongan">Tutup</button>
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
      this.dataPotongan = []
    }
  },
  data () {
    return {
      dataPotongan: []
    }
  },
  methods: {
    delData (index) {
      this.dataPotongan.splice(index, 1)
    },
    addData () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'InsertPotongan',
          potongans: this.dataPotongan
        }
      }).then(res => {
        $('#closeModalAddPotongan').trigger('click')
        this.$emit('onShowPopup', res.data.callback)
        $('#showModalAddDataPopup').trigger('click')
      }).catch(_ => {
        $('#closeModalAddPotongan').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalAddDataPopup').trigger('click')
      })
    }
  }
}
</script>
