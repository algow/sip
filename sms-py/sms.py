from datetime import datetime

class constructContent:

    def __init__(self, content):
        self.__kontak = content[0]
        self.__jenis = content[1]
        self.__nomor = content[2]
        self.__waktu = content[3]
        self.__keterangan = content[4]

    def __getTanggal(self):
        time = datetime.strptime(self.__waktu, '%Y-%m-%d') # datetime keturunannya date
        tanggal = time.strftime('%d %b %Y') # ini method punya date
        return tanggal

    def getKontak(self):
        return '+' + self.__kontak

    def message(self):
        pesan = """Dengan ini kami informasikan bahwa {0} saudara dengan nomor {1} yang disampaikan ke KPPN Jakarta III pada {2} ditolak.""".format(self.__jenis, self.__nomor, self.__getTanggal())
        return pesan
