from datetime import datetime

class sms:
    def __init__(self, content):
        self.__kontak = content[0]
        self.__jenis = content[1]
        self.__nomor = content[2]
        self.__waktu = content[3]
        self.__satker = content[4]

    def __getTanggal(self):
        time = datetime.strptime(self.__waktu, '%Y-%m-%d')  # datetime keturunannya date
        tanggal = time.strftime('%d %b %Y')                 # ini method punya date
        return tanggal

    def getKontak(self):
        return '+' + self.__kontak

    def message(self):
        pesan = "{0} no. {1} satker {2} yang disampaikan ke KPPN pada {3} DITOLAK. Mohon ambil berkas di KPPN Jakarta III. Pesan ini tidak untuk dibalas.".format(self.__jenis, self.__nomor,self.__satker, self.__getTanggal())
        return pesan
