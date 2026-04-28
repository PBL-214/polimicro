<?php

namespace Database\Seeders;

use App\Models\Makul;
use App\Models\Materi;
use App\Models\Pendaftaran;
use App\Models\PengerjaanTugas;
use App\Models\ProdiMikro;
use App\Models\Sertifikat;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Helper to create users with explicit role (role is not mass-assignable)
        $createUser = function(array $data, string $role) {
            $user = new User($data);
            $user->role = $role;
            $user->save();
            return $user;
        };

        // ====== USERS ======
        // Mahasiswa
        $mhs1 = $createUser(['name'=>'Ahmad Fauzi','email'=>'ahmad@student.polimicro.ac.id','password'=>'mahasiswa123','nim'=>'2024001','phone'=>'081234567890','status'=>'aktif'], 'mahasiswa');
        $mhs2 = $createUser(['name'=>'Siti Nurhaliza','email'=>'siti@student.polimicro.ac.id','password'=>'mahasiswa123','nim'=>'2024002','phone'=>'081234567891','status'=>'aktif'], 'mahasiswa');
        $mhs3 = $createUser(['name'=>'Budi Santoso','email'=>'budi@student.polimicro.ac.id','password'=>'mahasiswa123','nim'=>'2024003','phone'=>'081234567892','status'=>'aktif'], 'mahasiswa');
        $mhs4 = $createUser(['name'=>'Dewi Lestari','email'=>'dewi@student.polimicro.ac.id','password'=>'mahasiswa123','nim'=>'2024004','status'=>'pending'], 'mahasiswa');
        $mhs5 = $createUser(['name'=>'Rian Pratama','email'=>'rian@student.polimicro.ac.id','password'=>'mahasiswa123','nim'=>'2024005','status'=>'pending'], 'mahasiswa');

        // Dosen
        $dsn1 = $createUser(['name'=>'Dr. Hendra Wijaya','email'=>'hendra@dosen.polimicro.ac.id','password'=>'dosen123','nip'=>'198501012020011001','bidang'=>'Artificial Intelligence','phone'=>'082111222333','status'=>'aktif'], 'dosen');
        $dsn2 = $createUser(['name'=>'Prof. Ratna Sari','email'=>'ratna@dosen.polimicro.ac.id','password'=>'dosen123','nip'=>'197901012019012001','bidang'=>'Data Science','phone'=>'082111222334','status'=>'aktif'], 'dosen');
        $dsn3 = $createUser(['name'=>'Dr. Bambang Eko','email'=>'bambang@dosen.polimicro.ac.id','password'=>'dosen123','nip'=>'198201012021011001','bidang'=>'Cybersecurity','phone'=>'082111222335','status'=>'aktif'], 'dosen');

        // Admin
        $createUser(['name'=>'Admin PIC','email'=>'adminpic@polimicro.ac.id','password'=>'adminpic123','status'=>'aktif'], 'admin_pic');
        $createUser(['name'=>'Admin Akademik','email'=>'adminakademik@polimicro.ac.id','password'=>'adminakademik123','status'=>'aktif'], 'admin_akademik');

        // ====== PRODI ======
        $prodi1 = ProdiMikro::create(['kode_prodi'=>'PRD001','nama_prodi'=>'Artificial Intelligence','deskripsi'=>'Program studi microcredential yang berfokus pada pengembangan kecerdasan buatan, machine learning, dan deep learning untuk solusi industri.','durasi'=>'6 Bulan','icon'=>'🤖','status'=>'aktif']);
        $prodi2 = ProdiMikro::create(['kode_prodi'=>'PRD002','nama_prodi'=>'Data Science & Analytics','deskripsi'=>'Program studi untuk menguasai analisis data besar, statistik, dan visualisasi data untuk pengambilan keputusan bisnis.','durasi'=>'6 Bulan','icon'=>'📊','status'=>'aktif']);
        $prodi3 = ProdiMikro::create(['kode_prodi'=>'PRD003','nama_prodi'=>'Cybersecurity','deskripsi'=>'Program studi untuk menguasai keamanan jaringan, ethical hacking, dan pengelolaan risiko keamanan informasi.','durasi'=>'4 Bulan','icon'=>'🔒','status'=>'aktif']);
        $prodi4 = ProdiMikro::create(['kode_prodi'=>'PRD004','nama_prodi'=>'Cloud Computing','deskripsi'=>'Program studi microcredential tentang infrastruktur cloud, DevOps, dan pengelolaan layanan cloud modern.','durasi'=>'5 Bulan','icon'=>'☁️','status'=>'aktif']);
        $prodi5 = ProdiMikro::create(['kode_prodi'=>'PRD005','nama_prodi'=>'UI/UX Design','deskripsi'=>'Program studi tentang desain antarmuka pengguna, pengalaman pengguna, dan desain produk digital.','durasi'=>'4 Bulan','icon'=>'🎨','status'=>'aktif']);

        // ====== MAKUL ======
        $mk1 = Makul::create(['kode_makul'=>'MK001','nama_makul'=>'Dasar Machine Learning','deskripsi'=>'Pengantar konsep machine learning, supervised/unsupervised learning','sks'=>3,'prodi_id'=>$prodi1->id,'dosen_id'=>$dsn1->id]);
        $mk2 = Makul::create(['kode_makul'=>'MK002','nama_makul'=>'Deep Learning','deskripsi'=>'Neural networks, CNN, RNN, dan implementasi deep learning','sks'=>3,'prodi_id'=>$prodi1->id,'dosen_id'=>$dsn1->id]);
        $mk3 = Makul::create(['kode_makul'=>'MK003','nama_makul'=>'Natural Language Processing','deskripsi'=>'Pemrosesan bahasa alami, text mining, dan chatbot AI','sks'=>3,'prodi_id'=>$prodi1->id,'dosen_id'=>$dsn1->id]);
        $mk4 = Makul::create(['kode_makul'=>'MK004','nama_makul'=>'Statistik & Probabilitas','deskripsi'=>'Dasar statistik untuk analisis data dan pengambilan keputusan','sks'=>3,'prodi_id'=>$prodi2->id,'dosen_id'=>$dsn2->id]);
        $mk5 = Makul::create(['kode_makul'=>'MK005','nama_makul'=>'Data Visualization','deskripsi'=>'Teknik visualisasi data menggunakan tools modern','sks'=>2,'prodi_id'=>$prodi2->id,'dosen_id'=>$dsn2->id]);
        $mk6 = Makul::create(['kode_makul'=>'MK006','nama_makul'=>'Big Data Analytics','deskripsi'=>'Pengelolaan dan analisis data berskala besar','sks'=>3,'prodi_id'=>$prodi2->id,'dosen_id'=>$dsn2->id]);
        $mk7 = Makul::create(['kode_makul'=>'MK007','nama_makul'=>'Network Security','deskripsi'=>'Keamanan jaringan komputer dan protokol keamanan','sks'=>3,'prodi_id'=>$prodi3->id,'dosen_id'=>$dsn3->id]);
        $mk8 = Makul::create(['kode_makul'=>'MK008','nama_makul'=>'Ethical Hacking','deskripsi'=>'Penetration testing dan ethical hacking','sks'=>3,'prodi_id'=>$prodi3->id,'dosen_id'=>$dsn3->id]);

        // ====== MATERI ======
        Materi::create(['kode_materi'=>'MAT001','nama_materi'=>'Pengantar Machine Learning','deskripsi_materi'=>'Konsep dasar ML, tipe-tipe learning, dan pipeline ML','file_materi'=>'pengantar-ml.pdf','makul_id'=>$mk1->id]);
        Materi::create(['kode_materi'=>'MAT002','nama_materi'=>'Supervised Learning','deskripsi_materi'=>'Regresi, klasifikasi, decision tree, SVM','file_materi'=>'supervised-learning.pdf','makul_id'=>$mk1->id]);
        Materi::create(['kode_materi'=>'MAT003','nama_materi'=>'Neural Networks Basics','deskripsi_materi'=>'Arsitektur neural network, backpropagation','file_materi'=>'neural-networks.pdf','makul_id'=>$mk2->id]);
        Materi::create(['kode_materi'=>'MAT004','nama_materi'=>'Convolutional Neural Networks','deskripsi_materi'=>'CNN untuk image recognition dan computer vision','file_materi'=>'cnn.pdf','makul_id'=>$mk2->id]);
        Materi::create(['kode_materi'=>'MAT005','nama_materi'=>'Pengantar Statistik','deskripsi_materi'=>'Statistik deskriptif, distribusi, dan uji hipotesis','file_materi'=>'pengantar-statistik.pdf','makul_id'=>$mk4->id]);
        Materi::create(['kode_materi'=>'MAT006','nama_materi'=>'Dashboard Design','deskripsi_materi'=>'Prinsip desain dashboard yang efektif','file_materi'=>'dashboard-design.pdf','makul_id'=>$mk5->id]);
        Materi::create(['kode_materi'=>'MAT007','nama_materi'=>'Firewall & IDS','deskripsi_materi'=>'Konfigurasi firewall dan intrusion detection system','file_materi'=>'firewall-ids.pdf','makul_id'=>$mk7->id]);
        Materi::create(['kode_materi'=>'MAT008','nama_materi'=>'Vulnerability Assessment','deskripsi_materi'=>'Teknik penilaian kerentanan sistem','file_materi'=>'vuln-assessment.pdf','makul_id'=>$mk8->id]);

        // ====== TUGAS ======
        $tgs1 = Tugas::create(['kode_tugas'=>'TGS001','nama_tugas'=>'Implementasi Linear Regression','deskripsi_tugas'=>'Buat model regresi linier menggunakan dataset yang diberikan','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(14),'makul_id'=>$mk1->id]);
        $tgs2 = Tugas::create(['kode_tugas'=>'TGS002','nama_tugas'=>'Klasifikasi Gambar dengan CNN','deskripsi_tugas'=>'Bangun classifier gambar menggunakan CNN','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(21),'makul_id'=>$mk2->id]);
        $tgs3 = Tugas::create(['kode_tugas'=>'TGS003','nama_tugas'=>'Chatbot Sederhana','deskripsi_tugas'=>'Buat chatbot sederhana menggunakan NLP','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(28),'makul_id'=>$mk3->id]);
        $tgs4 = Tugas::create(['kode_tugas'=>'TGS004','nama_tugas'=>'Analisis Statistik Dataset','deskripsi_tugas'=>'Lakukan analisis statistik pada dataset terlampir','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(10),'makul_id'=>$mk4->id]);
        $tgs5 = Tugas::create(['kode_tugas'=>'TGS005','nama_tugas'=>'Dashboard Interaktif','deskripsi_tugas'=>'Buat dashboard interaktif menggunakan tools visualisasi','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(17),'makul_id'=>$mk5->id]);
        $tgs6 = Tugas::create(['kode_tugas'=>'TGS006','nama_tugas'=>'Network Security Audit','deskripsi_tugas'=>'Lakukan audit keamanan pada jaringan yang diberikan','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(14),'makul_id'=>$mk7->id]);
        $tgs7 = Tugas::create(['kode_tugas'=>'TGS007','nama_tugas'=>'Penetration Testing Report','deskripsi_tugas'=>'Buat laporan penetration testing lengkap','max_nilai'=>100,'tanggal_akhir_deadline'=>now()->addDays(21),'makul_id'=>$mk8->id]);

        // ====== PENDAFTARAN ======
        Pendaftaran::create(['mahasiswa_id'=>$mhs1->id,'prodi_id'=>$prodi1->id,'status'=>'diterima','registered_at'=>now()->subDays(30)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs1->id,'prodi_id'=>$prodi2->id,'status'=>'diterima','registered_at'=>now()->subDays(25)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs2->id,'prodi_id'=>$prodi1->id,'status'=>'diterima','registered_at'=>now()->subDays(28)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs2->id,'prodi_id'=>$prodi3->id,'status'=>'diterima','registered_at'=>now()->subDays(20)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs3->id,'prodi_id'=>$prodi2->id,'status'=>'diterima','registered_at'=>now()->subDays(22)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs3->id,'prodi_id'=>$prodi3->id,'status'=>'diterima','registered_at'=>now()->subDays(15)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs4->id,'prodi_id'=>$prodi1->id,'status'=>'pending','registered_at'=>now()->subDays(3)]);
        Pendaftaran::create(['mahasiswa_id'=>$mhs5->id,'prodi_id'=>$prodi4->id,'status'=>'pending','registered_at'=>now()->subDays(1)]);

        // ====== SUBMISSIONS ======
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs1->id,'tugas_id'=>$tgs1->id,'file_dikumpul'=>'ahmad_linear_regression.ipynb','waktu_kumpul'=>now()->subDays(5),'nilai'=>88,'feedback'=>'Implementasi bagus, coba tambahkan regularization']);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs1->id,'tugas_id'=>$tgs2->id,'file_dikumpul'=>'ahmad_cnn_classifier.py','waktu_kumpul'=>now()->subDays(3),'nilai'=>92,'feedback'=>'Excellent! Akurasi sangat baik']);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs1->id,'tugas_id'=>$tgs4->id,'file_dikumpul'=>'ahmad_statistik.xlsx','waktu_kumpul'=>now()->subDays(2),'nilai'=>null,'feedback'=>null]);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs2->id,'tugas_id'=>$tgs1->id,'file_dikumpul'=>'siti_linear_reg.py','waktu_kumpul'=>now()->subDays(4),'nilai'=>85,'feedback'=>'Good work']);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs2->id,'tugas_id'=>$tgs6->id,'file_dikumpul'=>'siti_security_audit.pdf','waktu_kumpul'=>now()->subDays(1),'nilai'=>null,'feedback'=>null]);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs3->id,'tugas_id'=>$tgs4->id,'file_dikumpul'=>'budi_analisis.pdf','waktu_kumpul'=>now()->subDays(6),'nilai'=>78,'feedback'=>'Perlu lebih detail di bagian uji hipotesis']);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs3->id,'tugas_id'=>$tgs5->id,'file_dikumpul'=>'budi_dashboard.html','waktu_kumpul'=>now()->subDays(2),'nilai'=>90,'feedback'=>'Dashboard sangat interaktif dan informatif!']);
        PengerjaanTugas::create(['mahasiswa_id'=>$mhs3->id,'tugas_id'=>$tgs6->id,'file_dikumpul'=>'budi_netsec_audit.pdf','waktu_kumpul'=>now()->subDays(1),'nilai'=>null,'feedback'=>null]);

        // ====== SERTIFIKAT ======
        Sertifikat::create(['mahasiswa_id'=>$mhs1->id,'prodi_id'=>$prodi1->id,'nomor_sertifikat'=>'CERT-PM-2026-001','tanggal_terbit'=>now()->subDays(5),'status'=>'diterbitkan']);
        Sertifikat::create(['mahasiswa_id'=>$mhs3->id,'prodi_id'=>$prodi2->id,'nomor_sertifikat'=>'CERT-PM-2026-002','tanggal_terbit'=>now()->subDays(2),'status'=>'diterbitkan']);
    }
}
