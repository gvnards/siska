<template>
  <!-- Modal -->
  <div class="modal fade" id="modalAddSlipGaji" tabindex="-1" role="dialog" aria-labelledby="modalAddSlipGajiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddSlipGajiLabel">Tambah Data Slip Gaji</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="item">
            <div class="each-item">
              <div class="form-group">
                <Datepicker v-model="dataSlip.tanggal" placeholder="Pilih Bulan Slip" :bootstrap-styling="true" />
              </div>
            </div>
            <div class="each-item">
              <div class="form-group">
                <select class="form-control" v-model="dataSlip.jenis">
                  <option disabled selected>Pilih Jenis Slip</option>
                  <option v-for="(item, index) in dataJenisSlip" :key="index" :value="parseInt(item.id)">{{ item.jenis }}</option>
                </select>
              </div>
            </div>
            <div class="each-item">
              <div class="form-group">
                <select class="form-control" v-model="dataSlip.asn">
                  <option disabled selected>Pilih ASN</option>
                  <option v-for="(item, index) in dataASN" :key="index" :value="item">{{ item.nama }}</option>
                </select>
              </div>
            </div>
            <div v-if="dataSlip.asn !== 'Pilih ASN' && dataSlip.jenis === 1">
              <div class="each-item">
                <div style="display: flex; justify-content: space-between;">
                  <div class="form-group">
                    <label for="masaKerja">Masa Kerja (tahun) :</label>
                    <input type="number" class="form-control" v-model="dataSlip.masaKerja" id="masaKerja">
                  </div>
                  <div class="form-group">
                    <label for="gajiPokok">Gaji Pokok :</label>
                    <input type="text" class="form-control" disabled id="gajiPokok" :placeholder="dataSlip.gajiPokok">
                  </div>
                </div>
                <div class="form-group" v-if="dataSlip.asn.eselon !== ''">
                  <label for="tunjanganJabatan">Tunjangan Jabatan :</label>
                  <input type="text" class="form-control" disabled id="tunjanganJabatan" :placeholder="kalkulasiTunjanganJabatan">
                </div>
                <div v-if="parseInt(dataKeluarga.status_perkawinan) === 1 || parseInt(dataKeluarga.jumlah_anak) !== 0">
                  <label>Tunjangan Keluarga :</label>
                  <div style="display: flex; justify-content: space-between;">
                    <div class="form-group" v-if="parseInt(dataKeluarga.status_perkawinan) === 1 && parseInt(dataKeluarga.is_greater_than) === 0">
                      <label for="tunjanganSuamiIstri">{{ dataSlip.asn.JENIS_KELAMIN === 'M' ? 'Istri' : 'Suami' }} :</label>
                      <input type="text" class="form-control" disabled id="tunjanganSuamiIstri" :placeholder="kalkulasiTunjanganSuamiIstri">
                    </div>
                    <div class="form-group" v-if="parseInt(dataKeluarga.status_perkawinan) === 1 && parseInt(dataKeluarga.jumlah_anak) !== 0">
                      <label for="tunjanganAnak">Anak :</label>
                      <input type="text" class="form-control" disabled id="tunjanganAnak" :placeholder="kalkulasiTunjanganAnak">
                    </div>
                  </div>
                </div>
                <div style="display: flex; justify-content: space-between;">
                  <div class="form-group" style="max-width: 50%;">
                    <label for="tunjanganBeras">Tunjangan Beras :</label>
                    <input type="text" class="form-control" disabled id="tunjanganBeras" :placeholder="kalkulasiTunjanganBeras">
                  </div>
                  <div class="form-group" style="max-width: 50%;">
                    <label for="tunjanganBPJS">Tunjangan BPJS :</label>
                    <input type="text" class="form-control" disabled id="tunjanganBPJS" :placeholder="kalkulasiBPJS">
                  </div>
                </div>
                <label>Tunjangan Jaminan :</label>
                <div style="display: flex; justify-content: space-between;">
                  <div class="form-group" style="max-width: 50%;">
                    <label for="tunjanganJKK">Kecelakaan Kerja :</label>
                    <input type="text" class="form-control" disabled id="tunjanganJKK" :placeholder="kalkulasiJKK">
                  </div>
                  <div class="form-group" style="max-width: 50%; align-self: flex-end;">
                    <label for="tunjanganJKM">Kematian :</label>
                    <input type="text" class="form-control" disabled id="tunjanganJKM" :placeholder="kalkulasiJKM">
                  </div>
                </div>
              </div>
              <div class="each-item-p">
                <label>Tunjangan :</label>
                <div class="form-group po" v-for="(item, index) in dataSlip.tunjangan" :key="index">
                  <select class="form-control" v-model="item.tunjangan">
                    <option disabled selected>Pilih Tunjangan</option>
                    <option v-for="(item, index) in dataTunjangan" :key="index" :value="item">{{ item.nama }} - <span v-if="item.jenis === 'Rp'">Rp {{ item.tunjangan | convertRp }}</span><span v-if="item.jenis === '%'">{{ item.tunjangan }} %</span></option>
                  </select>
                  <img @click="delData(index, 'tunjangan')" src="./../../assets/remove_red.png" alt="" srcset="">
                </div>
                <div class="btn btn-sm btn-success btn-block" style="font-size: 20px; padding: 2px; height: 18px; overflow: hidden;"><p style="margin-top: -8px;" @click="dataSlip.tunjangan.push({})">+</p></div>
              </div>
              <div class="each-item">
                <div class="form-group">
                  <label for="totalTunjangan">Total Tunjangan :</label>
                  <input type="text" class="form-control" disabled id="totalTunjangan" :placeholder="kalkulasiTotalTunjangan">
                </div>
              </div>
              <div style="margin-top: 24px; margin-bottom: 16px; overflow: hidden; text-align: center;">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
              <div class="each-item">
                <div class="form-group">
                  <label for="potonganBPJS">Potongan BPJS :</label>
                  <input type="text" class="form-control" disabled id="potonganBPJS" :placeholder="kalkulasiBPJS">
                </div>
              </div>
              <label>Potongan IWP :</label>
              <div style="display: flex; justify-content: space-between;">
                <div class="form-group" style="max-width: 50%;">
                  <label for="IWP1Persen">1 % :</label>
                  <input type="text" class="form-control" disabled id="IWP1Persen" :placeholder="kalkulasiIWP1Persen">
                </div>
                <div class="form-group" style="max-width: 50%; align-self: flex-end;">
                  <label for="IWP8Persen">8 % :</label>
                  <input type="text" class="form-control" disabled id="IWP8Persen" :placeholder="kalkulasiIWP8Persen">
                </div>
              </div>
              <div class="each-item">
                <label>Potongan Jaminan :</label>
                <div style="display: flex; justify-content: space-between;">
                  <div class="form-group" style="max-width: 50%;">
                    <label for="potonganJKK">Kecelakaan Kerja :</label>
                    <input type="text" class="form-control" disabled id="potonganJKK" :placeholder="kalkulasiJKK">
                  </div>
                  <div class="form-group" style="max-width: 50%; align-self: flex-end;">
                    <label for="potonganJKM">Kematian :</label>
                    <input type="text" class="form-control" disabled id="potonganJKM" :placeholder="kalkulasiJKM">
                  </div>
                </div>
              </div>
              <div class="each-item-p">
                <label>Potongan :</label>
                <div class="form-group po" v-for="(item, index) in dataSlip.potongan" :key="index">
                  <select class="form-control" v-model="item.potongan">
                    <option disabled selected>Pilih Potongan</option>
                    <option v-for="(item, index) in dataPotongan" :key="index" :value="item">{{ item.nama }} - <span v-if="item.jenis === 'Rp'">Rp {{ item.potongan | convertRp }}</span><span v-if="item.jenis === '%'">{{ item.potongan }} %</span></option>
                  </select>
                  <img @click="delData(index, 'potongan')" src="./../../assets/remove_red.png" alt="" srcset="">
                </div>
                <div class="btn btn-sm btn-success btn-block" style="font-size: 20px; padding: 2px; height: 18px; overflow: hidden;"><p style="margin-top: -8px;" @click="dataSlip.potongan.push({})">+</p></div>
              </div>
              <div class="each-item">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" v-model="dataSlip.isPotonganLainLain" id="isPotonganLainLain">
                  <label class="form-check-label" for="isPotonganLainLain">Potongan lain-lain</label>
                </div>
                <div class="form-group" v-if="dataSlip.isPotonganLainLain">
                  <input type="number" class="form-control" v-model="dataSlip.potonganLainLain" placeholder="Potongan Lain-lain">
                </div>
                <div class="each-item">
                  <div class="form-group">
                    <label for="totalPotongan">Total Potongan :</label>
                    <input type="text" class="form-control" disabled id="totalPotongan" :placeholder="kalkulasiTotalPotongan">
                  </div>
                </div>
                <div class="each-item">
                  <div class="form-group">
                    <label for="penerimaan">Penerimaan :</label>
                    <input type="text" class="form-control" disabled id="penerimaan" :placeholder="dataSlip.total">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalAddSlipGaji">Tutup</button>
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
label {
  font-size: 14px;
}
.item {
  .each-item {
    &-p {
      .po {
        display: flex;
        align-items: center;
        img {
          width: 18px;
          height: 18px;
          margin-left: 8px;
          cursor: pointer;
        }
      }
    }
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
import Datepicker from 'vuejs-datepicker'
export default {
  components: {
    Datepicker
  },
  props: {
    onModal: Boolean
  },
  watch: {
    onModal (val) {
      if (val) {
        this.resetData()
        this.dataASN = this.$store.state.pegawai
        this.dataASN = this.dataASN.sort((a, b) => (a.nama > b.nama) ? 1 : -1)
        this.getJenisSlip()
        this.getTunjangan()
        this.getPotongan()
      }
    },
    'dataSlip.masaKerja' (val) {
      if (val >= 0) {
        this.kalkulasiGajiPokok()
      }
    },
    'dataSlip.jenis' (val) {
      if (val === 1) {
        if (this.dataSlip.asn !== 'Pilih ASN') {
          this.kalkulasiGajiPokok()
        }
      }
    },
    'dataSlip.isPotonganLainLain' (val) {
      if (!val) {
        if (!isNaN(parseInt(this.dataSlip.potonganLainLain))) {
          this.kalkulasiTotalPotongan -= parseInt(this.dataSlip.potonganLainLain)
          this.dataSlip.potonganLainLain = 0
          this.tempPotonganLain = 0
        }
      }
    },
    'dataSlip.potonganLainLain' (val) {
      if (this.dataSlip.isPotonganLainLain) {
        if (!isNaN(parseInt(this.dataSlip.potonganLainLain))) {
          this.kalkulasiTotalPotongan -= this.tempPotonganLain
          this.kalkulasiTotalPotongan += parseInt(this.dataSlip.potonganLainLain)
          this.tempPotonganLain = val
        }
      }
      this.dataSlip.total = (this.dataSlip.gajiPokok + this.kalkulasiTotalTunjangan) - this.kalkulasiTotalPotongan
    },
    'dataSlip.asn' (val) {
      if (val !== 'Pilih ASN') {
        if (this.dataSlip.jenis === 1) {
          this.kalkulasiGajiPokok()
        }
        this.getProfilKeluarga()
      }
    },
    'dataSlip.potongan': {
      deep: true,
      handler (val) {
        this.kalkulasiTotPotongan(val)
      }
    },
    'dataSlip.tunjangan': {
      deep: true,
      handler (val) {
        this.kalkulasiTotTunjangan(val)
      }
    }
  },
  data () {
    return {
      kalkulasiTotalPotongan: 0,
      kalkulasiTotalTunjangan: 0,
      dataTunjangan: [],
      dataPotongan: [],
      dataJenisSlip: [],
      dataASN: [
        {
          asn: '199601162019031001',
          nama: 'GIOVANI ARDIANSYAH'
        }
      ],
      dataSlip: {
        asn: 'Pilih ASN',
        idGolongan: -1,
        masaKerja: 0,
        gajiPokok: 0,
        jenis: 'Pilih Jenis Slip',
        tanggal: '',
        tunjangan: [],
        potongan: [],
        isPotonganLainLain: false,
        potonganLainLain: 0,
        totalPotongan: 0,
        total: 0
      },
      tempPotonganLain: 0,
      dataKeluarga: Object
    }
  },
  computed: {
    kalkulasiTunjanganJabatan () {
      let eselon = this.dataSlip.asn.eselon
      if (eselon !== '') {
        if (eselon === '11') {
          return 5500000
        } else if (eselon === '12') {
          return 4375000
        } else if (eselon === '21') {
          return 3250000
        } else if (eselon === '22') {
          return 2025000
        } else if (eselon === '31') {
          return 1260000
        } else if (eselon === '32') {
          return 980000
        } else if (eselon === '41') {
          return 540000
        } else if (eselon === '42') {
          return 490000
        } else if (eselon === '51') {
          return 360000
        }
      }
      return 0
    },
    kalkulasiTunjanganFungsionalTertentu () {
      let total = 0
      let jabatan = this.dataSlip.asn.nama_jabatan.toLowerCase()
      let jenjang = ''

      // ANALIS KEPEGAWAIAN --> BERDASARKAN Peraturan Presiden (PERPRES) Nomor 17 Tahun 2013
      if (jabatan.includes('analis kepegawaian')) {
        jenjang = jabatan.split('analis kepegawaian')[1]

        if (jenjang.includes('pelaksana lanjutan')) {
          total += 420000
        } else if (jenjang.includes('pelaksana')) {
          total += 330000
        } else if (jenjang.includes('penyelia')) {
          total += 600000
        } else if (jenjang.includes('pertama')) {
          total += 480000
        } else if (jenjang.includes('muda')) {
          total += 840000
        } else if (jenjang.includes('madya')) {
          total += 1080000
        }
      }

      return total
    },
    kalkulasiTunjanganFungsionalUmum () {
      let golongan = this.dataSlip.asn.GOL_NAMA.split('/')[0]
      if (golongan === 'I') {
        return 175000
      } else if (golongan === 'II') {
        return 180000
      } else if (golongan === 'III') {
        return 185000
      } else if (golongan === 'IV') {
        return 190000
      }
      return 0
    },
    kalkulasiTunjanganSuamiIstri () {
      if (parseInt(this.dataKeluarga.status_perkawinan) === 1 && parseInt(this.dataKeluarga.is_greater_than) === 0) {
        return this.dataSlip.gajiPokok * 10 / 100
      }
      return 0
    },
    kalkulasiTunjanganAnak () {
      return (this.dataSlip.gajiPokok * 2 / 100) * parseInt(this.dataKeluarga.jumlah_anak)
    },
    kalkulasiTunjanganBeras () {
      let temp = 72420
      if (parseInt(this.dataKeluarga.status_perkawinan) === 1 && parseInt(this.dataKeluarga.is_greater_than) === 0) {
        temp += 72420
      }
      temp += (72420 * parseInt(this.dataKeluarga.jumlah_anak))
      return temp
    },
    kalkulasiJKK () {
      return Math.round((this.dataSlip.gajiPokok * 0.24) / 100)
    },
    kalkulasiJKM () {
      return Math.round((this.dataSlip.gajiPokok * 0.72) / 100)
    },
    kalkulasiBPJS () {
      let total = 0
      total += this.dataSlip.gajiPokok + this.kalkulasiTunjanganSuamiIstri + this.kalkulasiTunjanganAnak
      if (this.dataSlip.asn.eselon !== '') {
        total += this.kalkulasiTunjanganJabatan
      } else {
        if (this.dataSlip.asn.jenis_jabatan === 'jft') {
          total += this.kalkulasiTunjanganFungsionalTertentu
        } else {
          total += this.kalkulasiTunjanganFungsionalUmum
        }
      }
      return Math.round((total * 4) / 100)
    },
    kalkulasiIWP8Persen () {
      let total = 0
      total += this.dataSlip.gajiPokok + this.kalkulasiTunjanganSuamiIstri + this.kalkulasiTunjanganAnak
      return Math.round((total * 8) / 100)
    },
    kalkulasiIWP1Persen () {
      let total = 0
      total += this.dataSlip.gajiPokok + this.kalkulasiTunjanganSuamiIstri + this.kalkulasiTunjanganAnak
      if (this.dataSlip.asn.eselon !== '') {
        total += this.kalkulasiTunjanganJabatan
      } else {
        if (this.dataSlip.asn.jenis_jabatan === 'jft') {
          total += this.kalkulasiTunjanganFungsionalTertentu
        } else {
          total += this.kalkulasiTunjanganFungsionalUmum
        }
      }
      return Math.round((total * 1) / 100)
    }
  },
  methods: {
    getProfilKeluarga () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetProfil',
          nip: this.dataSlip.asn.nip
        }
      }).then(res => {
        this.dataKeluarga = res.data
      })
    },
    kalkulasiGajiPokok () {
      if (this.dataSlip.jenis === 1 && this.dataSlip.asn !== 'Pilih ASN') {
        axios({
          url: `${this.$store.state.BASED_URL}siska_server/index.php`,
          method: 'GET',
          params: {
            nocache: new Date().getTime(),
            onGet: 'GetGaji',
            golongan: this.dataSlip.asn.GOL_NAMA,
            masaKerja: this.dataSlip.masaKerja
          }
        }).then(res => {
          if (res.data[0] === undefined) {
            this.dataSlip.total = 0
          }
          this.dataSlip.gajiPokok = 0
          this.dataSlip.idGolongan = res.data[0].id
          this.dataSlip.gajiPokok = parseFloat(res.data[0].gaji)
          this.dataSlip.total = (this.dataSlip.gajiPokok + this.kalkulasiTotalTunjangan) - this.kalkulasiTotalPotongan
          this.kalkulasiTotTunjangan(this.dataSlip.tunjangan)
          this.kalkulasiTotPotongan(this.dataSlip.potongan)
        })
      }
    },
    kalkulasiTotPotongan (totalPotongan) {
      let total = 0
      // let tempGajiPokok = this.dataSlip.gajiPokok
      if (totalPotongan.length > 0) {
        totalPotongan.forEach(el => {
          if (el.potongan !== undefined) {
            if (el.potongan.jenis === 'Rp') {
              total += parseInt(el.potongan.potongan)
              // tempGajiPokok -= parseInt(el.potongan.potongan)
            } else if (el.potongan.jenis === '%') {
              let persen = (this.dataSlip.gajiPokok * parseFloat(el.potongan.potongan)) / 100
              total += persen
            }
          }
        })
      }
      this.kalkulasiTotalPotongan = total + this.kalkulasiJKK + this.kalkulasiJKM + this.kalkulasiBPJS + this.kalkulasiIWP1Persen + this.kalkulasiIWP8Persen
      if (this.dataSlip.isPotonganLainLain) {
        if (!isNaN(parseInt(this.dataSlip.potonganLainLain))) {
          this.kalkulasiTotalPotongan += parseFloat(this.dataSlip.potonganLainLain)
        }
      }
      this.dataSlip.total = (this.dataSlip.gajiPokok + this.kalkulasiTotalTunjangan) - this.kalkulasiTotalPotongan
    },
    kalkulasiTotTunjangan (totalTunjangan) {
      let total = 0
      // let tempGajiPokok = this.dataSlip.gajiPokok
      if (totalTunjangan.length > 0) {
        totalTunjangan.forEach(el => {
          if (el.tunjangan !== undefined) {
            if (el.tunjangan.jenis === 'Rp') {
              total += parseInt(el.tunjangan.tunjangan)
              // tempGajiPokok -= parseInt(el.tunjangan.tunjangan)
            } else if (el.tunjangan.jenis === '%') {
              let persen = (this.dataSlip.gajiPokok * parseFloat(el.tunjangan.tunjangan)) / 100
              total += persen
            }
          }
        })
      }
      this.kalkulasiTotalTunjangan = total + this.kalkulasiTunjanganJabatan + this.kalkulasiTunjanganSuamiIstri + this.kalkulasiTunjanganAnak + this.kalkulasiTunjanganBeras + this.kalkulasiJKK + this.kalkulasiJKM + this.kalkulasiBPJS
      this.dataSlip.total = (this.dataSlip.gajiPokok + this.kalkulasiTotalTunjangan) - this.kalkulasiTotalPotongan
    },
    delData (index, mode) {
      if (mode === 'tunjangan') {
        this.dataSlip.tunjangan.splice(index, 1)
      } else if (mode === 'potongan') {
        this.dataSlip.potongan.splice(index, 1)
      }
    },
    resetData () {
      this.dataSlip = {
        asn: 'Pilih ASN',
        masaKerja: 0,
        gajiPokok: 0,
        jenis: 'Pilih Jenis Slip',
        tanggal: '',
        tunjangan: [],
        potongan: [],
        isPotonganLainLain: false,
        potonganLainLain: 0,
        total: 0
      }
    },
    getTunjangan () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetTunjangan'
        }
      }).then(res => {
        this.dataTunjangan = res.data
      })
    },
    getPotongan () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetPotongan'
        }
      }).then(res => {
        this.dataPotongan = res.data
      })
    },
    getJenisSlip () {
      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetJenisSlip'
        }
      }).then(res => {
        this.dataJenisSlip = res.data
      })
    },
    addData () {
      let dataSlip = {...this.dataSlip}
      dataSlip.asn = {
        nip: dataSlip.asn.nip,
        nama: dataSlip.asn.nama
      }
      if (dataSlip.potongan.length > 0) {
        dataSlip.potongan.forEach((el, idx) => {
          dataSlip.potongan[idx] = el.potongan.id
        })
      } else {
        dataSlip.potongan = [0]
      }
      if (dataSlip.tunjangan.length > 0) {
        dataSlip.tunjangan.forEach((el, idx) => {
          dataSlip.tunjangan[idx] = el.tunjangan.id
        })
      } else {
        dataSlip.tunjangan = [0]
      }
      dataSlip.tanggal = `${dataSlip.tanggal.getFullYear()}-${dataSlip.tanggal.getMonth() + 1}-${dataSlip.tanggal.getDate()}`

      axios({
        url: `${this.$store.state.BASED_URL}siska_server/index.php`,
        method: 'POST',
        data: {
          onPost: 'InsertSlipGaji',
          nip: dataSlip.asn.nip,
          nama: dataSlip.asn.nama,
          jenis: dataSlip.jenis,
          golongan: dataSlip.idGolongan,
          tunjanganJabatan: this.kalkulasiTunjanganJabatan,
          tunjanganSuamiIstri: this.kalkulasiTunjanganSuamiIstri,
          tunjanganAnak: this.kalkulasiTunjanganAnak,
          tunjanganBeras: this.kalkulasiTunjanganBeras,
          jkk: this.kalkulasiJKK,
          jkm: this.kalkulasiJKM,
          bpjs: this.kalkulasiBPJS,
          iwp1: this.kalkulasiIWP1Persen,
          iwp8: this.kalkulasiIWP8Persen,
          idPotongan: dataSlip.potongan,
          idPotonganLainLain: dataSlip.potonganLainLain,
          idTunjangan: dataSlip.tunjangan,
          tanggalSlip: dataSlip.tanggal,
          totalGaji: dataSlip.total,
          totalTunjangan: this.kalkulasiTotalTunjangan,
          totalPotongan: this.kalkulasiTotalPotongan
        }
      }).then(res => {
        $('#closeModalAddSlipGaji').trigger('click')
        this.$emit('onShowPopup', res.data.callback)
        $('#showModalAddDataPopup').trigger('click')
        this.$emit('refreshData')
      }).catch(_ => {
        $('#closeModalAddSlipGaji').trigger('click')
        this.$emit('onShowPopup', false)
        $('#showModalAddDataPopup').trigger('click')
        this.$emit('refreshData')
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
  }
}
</script>
