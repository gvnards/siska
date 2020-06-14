<template>
  <!-- Modal -->
  <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalImportLabel">Impor Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-danger">
            <small>* Unduh contoh kerangka Excel <a href="https://siska.bkpsdmsitubondo.id/kerangka.xls">Di Sini</a></small>
            <br />
            <small>* Pastikan file berekstensi <strong><i>.xls</i></strong> atau Save As dalam <strong><i>Excel 97-2003 Template</i></strong></small>
          </p>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="validatedCustomFile" required accept=".xls" ref="file" @change="handleFileUpload()">
            <label class="custom-file-label" for="validatedCustomFile" style="font-size: 12px;">{{ file.name === undefined ? 'Pilih berkas...' : file.name }}</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="closeModalImport">Tutup</button>
          <button type="button" class="btn btn-sm btn-success" @click="submitFile()">Impor</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>

</style>

<script>
import axios from 'axios'
import $ from 'jquery'
export default {
  data () {
    return {
      file: ''
    }
  },
  methods: {
    submitFile () {
      let formData = new FormData()

      formData.append('file', this.file)
      formData.append('onPost', 'ImportDBExcelGajiPokok')
      axios({
        method: 'POST',
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        data: formData,
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then((res) => {
        if (res.data.callback) {
          $('#closeModalImport').trigger('click')
          this.$emit('onShowPopup', res.data.callback)
          $('#showModalAddDataPopup').trigger('click')
        } else {
          $('#closeModalImport').trigger('click')
          this.$emit('onShowPopup', false)
          $('#showModalAddDataPopup').trigger('click')
        }
      }).catch(() => {
        $('#closeModalImport').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalAddDataPopup').trigger('click')
      })
    },
    handleFileUpload () {
      this.file = this.$refs.file.files[0]
    }
  }
}
</script>
