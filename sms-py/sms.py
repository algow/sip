from sys import argv
import json, gammu
from datetime import datetime

class constructContent:

    def __init__(self, content):
        self.__kontak = loadMessage[0]
        self.__jenis = loadMessage[1]
        self.__nomor = loadMessage[2]
        self.__waktu = loadMessage[3]
        self.__keterangan = loadMessage[4]

    def __getTanggal(self):
        time = datetime.strptime(self.__waktu, '%Y-%m-%d') # datetime keturunannya date
        tanggal = time.strftime('%d %b %Y') # ini method punya date
        return tanggal

    def getKontak(self):
        return '+' + self.__kontak

    def message(self):
        pesan = """Dengan ini kami informasikan bahwa {0} saudara dengan nomor {1} yang disampaikan ke KPPN pada {2} ditolak dengan alasan \"{3}\". Mohon untuk segera memperbaiki dan menyampaikan kembali dokumen ke loket 9 atau 10 KPPN.
                \nBantu kami mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM) dengan cara tidak memberikan gratifikasi dalam bentuk apapun kepada para pegawai KPPN Jakarta III.""".format(self.__jenis, self.__nomor, self.__getTanggal(), self.__keterangan)
        return pesan

loadMessage = json.loads(argv[1])
content = constructContent(loadMessage)
print(content.message())
