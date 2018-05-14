
from sys import argv
import json, gammu
from datetime import datetime

class constructContent:
    def __init__(self, content):
        self.kontak = loadMessage[0]
        self.jenis = loadMessage[1]
        self.nomor = loadMessage[2]
        self.waktu = loadMessage[3]
        self.keterangan = loadMessage[4]

    def getKontak:
        return '+' + self.kontak

    def getJenis:
        return self.jenis

    def getNomor:
        return self.nomor

    def getWaktu:
        time = datetime.strptime(self.waktu, '%Y-%m-%d') # datetime keturunannya date
        tanggal = time.strftime('%d %b %Y') # ini method punya date
        return tanggal

    def getKeterangan:
        return self.keterangan

loadMessage = json.loads(argv[1])

kontak = loadMessage[0]
jenis = loadMessage[1]
nomor = loadMessage[2]
waktu = datetime.strptime(loadMessage[3], '%Y-%m-%d') # datetime keturunannya date
keterangan = loadMessage[4]
tanggal = waktu.strftime('%d %b %Y') # ini method punya date

pesan = """Dengan ini kami informasikan bahwa {0} saudara dengan nomor {1} yang disampaikan ke KPPN pada {2} ditolak dengan alasan \"{3}\". Mohon untuk segera memperbaiki dan menyampaikan kembali dokumen ke loket 9 atau 10 KPPN.
        \nBantu kami mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM) dengan cara tidak memberikan gratifikasi dalam bentuk apapun kepada para pegawai KPPN Jakarta III.""".format(jenis, nomor, tanggal, keterangan)
