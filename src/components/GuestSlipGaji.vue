<template>
  <div>
    <!-- Button -->
    <button class="btn" data-toggle="modal" id="show-modal-guest-slipGaji" data-target="#modal-guest-slipGaji" hidden>Click Me</button>
    <!-- Modal -->
    <div class="modal fade" id="modal-guest-slipGaji" tabindex="-1" role="dialog" aria-labelledby="modal-guest-slipGajiLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-guest-slipGajiLabel">Slip Gaji</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <select class="form-control" v-model="userData.jenis">
                <option disabled selected>Pilih Jenis Slip</option>
                <option v-for="(item, index) in provideData.jenisSlip" :key="index" :value="parseInt(item.id)">{{ item.jenis }}</option>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" v-model="userData.asn">
                <option disabled selected>Pilih ASN</option>
                <option v-for="(item, index) in provideData.dataASN" :key="index" :value="item">{{ item.nama }}</option>
              </select>
            </div>
            <div class="form-group">
              <Datepicker v-model="userData.tanggal" placeholder="Pilih Bulan Slip" :bootstrap-styling="true" />
            </div>
            <button class="btn btn-primary btn-block" :disabled="!isFulfilled"
            :style="!isFulfilled ? 'cursor: not-allowed;' : ''" @click="toUrl()">Unduh Slip</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="less" scoped>

</style>

<script>
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'
export default {
  components: {
    Datepicker
  },
  data () {
    return {
      provideData: {
        jenisSlip: [],
        dataASN: []
      },
      userData: {
        tanggal: '',
        jenis: 'Pilih Jenis Slip',
        asn: 'Pilih ASN'
      }
    }
  },
  methods: {
    toUrl () {
      let tempTanggal = new Date(this.userData.tanggal)
      window.open(`${this.$store.state.BASED_URL}siska_slip/?onGet=GetSlipGaji&bulan=${tempTanggal.getMonth() + 1 < 10 ? '0' + (tempTanggal.getMonth() + 1) : tempTanggal.getMonth() + 1}&tahun=${tempTanggal.getFullYear()}&nips=${this.userData.asn.nip}`)
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
        this.provideData.jenisSlip = res.data
      })
    },
    getASN () {
      axios({
        url: 'https://server.cuti.bkpsdmsitubondo.id/',
        method: 'GET',
        params: {
          nocache: new Date().getTime(),
          onGet: 'GetPegawaiAdmin',
          opd_id: 5
        }
      }).then(res => {
        this.provideData.dataASN = res.data.pegawai
      })
    }
  },
  computed: {
    isFulfilled () {
      return this.userData.tanggal !== '' && this.userData.jenis !== 'Pilih Jenis Slip' && this.userData.asn !== 'Pilih ASN'
    }
  },
  created () {
    this.getJenisSlip()
    this.getASN()
  }
}
</script>
