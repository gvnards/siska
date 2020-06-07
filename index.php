<?php
  require "fpdf.php";
  header("Access-Control-Allow-Origin: *");

  $data = json_decode(file_get_contents("http://127.0.0.1/siska_server/?onGet=GetSlipGajiExport&idSlip=$_GET[idSlip]"));

  class myPDF extends FPDF {
    function header () {
      $this->SetFont('Arial', 'B', 12);
      $this->SetFillColor(62, 115, 185);
      $this->SetTextColor(255, 255, 255);
      $this->MultiCell(0, 8, "SLIP GAJI ASN BKPSDM KABUPATEN SITUBONDO", 0, "C", true);
    }
    function footer () {
      $this->SetY(-40);
      $this->SetFont('Arial', 'B', 12);
      $this->MultiCell(0, 6, "Catatan :", 0, "L");
      $this->SetFont('Arial', '', 10);
      $this->MultiCell(0, 6, "Slip ini sesuai dengan data yang dimasukkan", 0, "L");
      $this->MultiCell(0, 6, "Jika ada kesalahan, silahkan hubungi Admin Keuangan BKPSDM", 0, "L");
      $this->SetFillColor(62, 115, 185);
      $this->SetTextColor(255, 255, 255);
      $this->MultiCell(0, 8, "", 0, "C", true);
    }
    function my () {
      global $data;

      $this->SetFont('Arial', 'B', 12);
      $this->Ln();
      $this->Cell(0, 6, "BKPSDM KABUPATEN SITUBONDO", 0, 1);
      $this->SetFont('Arial', '', 10);
      $this->Cell(0, 6, "Jalan Madura Nomor 3, Mimbaan, Panji", 0, 1);

      $this->Ln();
      $this->Ln();
      $this->SetFont('Arial', 'B', 10);
      $y = $this->GetY();
      $x = $this->GetX();
      $this->Cell((184.6/3) - 6, 6, "SLIP UNTUK", 0, 1, 'L');
      $this->SetFont('Arial', '', 10);
      $this->MultiCell((184.6/3) - 6, 4, $data->slip->nama, 'B', 'L');
      $this->MultiCell((184.6/3) - 6, 4, $data->slip->nip, 0, 'L');

      $this->SetY($y);
      $this->SetX($this->GetX() + 184.6/3);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell((184.6/3) - 6, 6, "SLIP DARI", 0, 1, 'L');
      $this->SetFont('Arial', '', 10);
      $this->SetX($this->GetX() + 184.6/3);
      $this->MultiCell(((184.6/3) - 6), 4, "Admin Keuangan", 0, 'L');
      $this->SetX($this->GetX() + 184.6/3);
      $this->MultiCell(((184.6/3) - 6), 4, "BKPSDM Kabupaten Situbondo", 0, 'L');

      $this->SetY($y);
      $this->SetX($this->GetX() + 184.6/3*2);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell((184.6/3) - 6, 6, "SLIP #", 0, 1, 'L');
      $this->SetFont('Arial', '', 10);
      $this->SetX($this->GetX() + 184.6/3*2);
      $this->MultiCell(((184.6/3) - 6), 4, "#Print", 0, 'L');
      $this->SetX($this->GetX() + 184.6/3*2);
      $this->MultiCell(((184.6/3) - 6), 4, ">>>>> ".$this->convertTanggal($data->slip->tanggal_slip)." <<<<<", 0, 'L');

      $this->Ln();
      $this->Ln();
      $this->Ln();
      $this->SetFont('Arial', 'B', 18);
      $this->Cell((184.6/2), 18, "PENERIMAAN", 'TB', 0, 'L');
      $this->Cell((184.6/2), 18, $this->convertRp($data->slip->total_gaji), 'TB', 1, 'R');

      $this->Ln(1);

      // ------------------------------------------------------ PEMASUKAN
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(0, 6, "Rincian Pemasukan", 0, 1, 'L');

      $this->Cell((184.6/3) - 45, 6, "No.", 0, 0, 'L');
      $this->Cell((184.6/3) + (45/2), 6, "Deskripsi", 0, 0, 'L');
      $this->Cell((184.6/3) + (45/2), 6, "Pemasukan", 0, 1, 'R');

      $this->SetFont('Arial', '', 10);
      $countPemasukan = 1;
      // GAJI POKOK
      $this->Cell((184.6/3) - 45, 6, $countPemasukan, 0, 0, 'L');
      $this->Cell((184.6/3) + (45/2), 6, 'Gaji Pokok', 0, 0, 'L');
      $this->Cell((184.6/3) + (45/2), 6, $this->convertRp($data->slip->gaji_pokok), 0, 1, 'R');
      $countPemasukan++;
      // TUNJANGAN JABATAN
      if (intval($data->slip->tunjangan_jabatan) != 0) {
        $this->Cell((184.6/3) - 45, 6, $countPemasukan, 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, 'Tunjangan Jabatan', 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, $this->convertRp($data->slip->tunjangan_jabatan), 0, 1, 'R');
        $countPemasukan++;
      }
      // TUNJANGAN SUAMI/ISTRI
      if (intval($data->slip->tunjangan_suami_istri) != 0) {
        $this->Cell((184.6/3) - 45, 6, $countPemasukan, 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, 'Tunjangan Suami/Istri', 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, $this->convertRp($data->slip->tunjangan_suami_istri), 0, 1, 'R');
        $countPemasukan++;
      }
      // TUNJANGAN ANAK
      if (intval($data->slip->tunjangan_anak) != 0) {
        $this->Cell((184.6/3) - 45, 6, $countPemasukan, 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, 'Tunjangan Anak', 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, $this->convertRp($data->slip->tunjangan_anak), 0, 1, 'R');
        $countPemasukan++;
      }
      // TUNJANGAN LAIN
      foreach ($data->tunjangan as $key => $tunjangan) {
        if (intval($tunjangan->tunjangan) != 0) {
          // if ($currNip === $tunjangan->nip && $allDates[$idx] === $tunjangan->tanggal_slip) {
          $countPemasukan++;
          $this->Cell((184.6/3) - 45, 6, ($countPemasukan), 0, 0, 'L');
          $this->Cell((184.6/3) + (45/2), 6, $tunjangan->nama, 0, 0, 'L');
          $this->Cell((184.6/3) + (45/2), 6, $tunjangan->jenis === "Rp" ? $this->convertRp($tunjangan->tunjangan) : $tunjangan->tunjangan." % --- ".$this->convertRp($this->percentToRp($data->slip->gaji_pokok, $tunjangan->tunjangan)), 0, 1, 'R');
          // }
        }
      }
      // TOTAL PEMASUKAN KOTOR
      $this->Ln(2);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell((((184.6/3) - 45) + ((184.6/3) + (45/2))), 10, "Jumlah Pemasukan", 'T', 'L');
      $this->Cell((184.6/3) + (45/2), 10, $this->convertRp((intval($data->slip->gaji_pokok) + intval($data->slip->tunjangan_jabatan) + intval($data->slip->tunjangan_suami_istri) + intval($data->slip->tunjangan_anak) + intval($data->slip->total_tunjangan)).""), 'T', 1, 'R');

      $this->Ln(4);
      $this->Cell(0, 0, '', 'B', 1, '');

      // ------------------------------------------------------ POTONGAN
      $this->Ln(6);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(0, 6, "Rincian Potongan", 0, 1, 'L');

      $this->Cell((184.6/3) - 45, 6, "No.", 0, 0, 'L');
      $this->Cell((184.6/3) + (45/2), 6, "Deskripsi", 0, 0, 'L');
      $this->Cell((184.6/3) + (45/2), 6, "Potongan", 0, 1, 'R');

      $this->SetFont('Arial', '', 10);
      $countPotongan = 0;
      foreach ($data->potongan as $key => $potongan) {
        if (intval($potongan->potongan) != 0) {
          // if ($currNip === $potongan->nip && $allDates[$idx] === $potongan->tanggal_slip) {
          $countPotongan++;
          $this->Cell((184.6/3) - 45, 6, ($countPotongan), 0, 0, 'L');
          $this->Cell((184.6/3) + (45/2), 6, $potongan->nama, 0, 0, 'L');
          $this->Cell((184.6/3) + (45/2), 6, $potongan->jenis === "Rp" ? $this->convertRp($potongan->potongan) : $potongan->potongan." % --- ".$this->convertRp($this->percentToRp($data->slip->gaji_pokok, $potongan->potongan)), 0, 1, 'R');
          // }
        }
      }
      if (intval($data->slip->potongan_lainlain) != 0) {
        $this->Cell((184.6/3) - 45, 6, ($countPotongan+1), 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, $data->slip->nama_potongan_lainlain, 0, 0, 'L');
        $this->Cell((184.6/3) + (45/2), 6, $this->convertRp($data->slip->potongan_lainlain), 0, 1, 'R');
      }
      $this->Ln(2);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell((((184.6/3) - 45) + ((184.6/3) + (45/2))), 10, "Jumlah Potongan", 'T', 'L');
      $this->Cell((184.6/3) + (45/2), 10, $this->convertRp($data->slip->total_potongan), 'T', 1, 'R');
    }
    function convertTanggal ($tanggal) {
      $tempTanggal = array_reverse(explode("-", $tanggal));
      $listMonth = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"];
      
      return $listMonth[intval($tempTanggal[1])-1]." ".$tempTanggal[2];;
    }
    function percentToRp ($gajiPokok, $percent) {
      $perToRp = round(($gajiPokok * $percent) / 100);
      return "".$perToRp;
    }
    function convertRp ($uang) {
      $tempUang = "";
      $count = 0;
      for ($i = strlen($uang)-1; $i >= 0; $i--) {
        $count++;
        $tempUang = $uang[$i].$tempUang;
        if ($count%3 === 0) {
          $tempUang = ".".$tempUang;
          $count = 0;
        }
      }
      if (!empty($tempUang)) {
        if ($tempUang[0] === ".") {
          $tempUang = substr($tempUang, 1);
        }
      }
      return $tempUang;
    }
    function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
      // Calculate MultiCell with automatic or explicit line breaks height
      // $border is un-used, but I kept it in the parameters to keep the call
      //   to this function consistent with MultiCell()
      $cw = &$this->CurrentFont['cw'];
      if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
      $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
      $s = str_replace("\r",'',$txt);
      $nb = strlen($s);
      if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
      $sep = -1;
      $i = 0;
      $j = 0;
      $l = 0;
      $ns = 0;
      $height = 0;
      while($i<$nb)
      {
        // Get next character
        $c = $s[$i];
        if($c=="\n")
        {
          // Explicit line break
          if($this->ws>0)
          {
            $this->ws = 0;
            $this->_out('0 Tw');
          }
          //Increase Height
          $height += $h;
          $i++;
          $sep = -1;
          $j = $i;
          $l = 0;
          $ns = 0;
          continue;
        }
        if($c==' ')
        {
          $sep = $i;
          $ls = $l;
          $ns++;
        }
        $l += $cw[$c];
        if($l>$wmax)
        {
          // Automatic line break
          if($sep==-1)
          {
            if($i==$j)
              $i++;
            if($this->ws>0)
            {
              $this->ws = 0;
              $this->_out('0 Tw');
            }
            //Increase Height
            $height += $h;
          }
          else
          {
            if($align=='J')
            {
              $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
              $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
            }
            //Increase Height
            $height += $h;
            $i = $sep+1;
          }
          $sep = -1;
          $j = $i;
          $l = 0;
          $ns = 0;
        }
        else
          $i++;
      }
      // Last chunk
      if($this->ws>0)
      {
        $this->ws = 0;
        $this->_out('0 Tw');
      }
      //Increase Height
      $height += $h;

      return $height;
    }
  }

  $pdf = new myPDF('P', 'mm', array(210, 330));
  $pdf->SetMargins(12.7, 12.7, 12.7);
  $pdf->AddPage('P', array(210, 330), 0);
  $pdf->Image('./img/bg-img.png', 25, 40, 160);
  $pdf->my();
  $pdf->Output('I', 'doc.pdf', true);