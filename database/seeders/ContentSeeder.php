<?php

namespace Database\Seeders;

use App\Models\ContentModel;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentModel::insert([
            [
                'type' => 'profile',
                'title_indo' => 'UPA BAHASA POLITEKNIK NEGERI MALANG',
                'title_english' => 'UPA BAHASA STATE POLYTECHNIC OF MALANG',
                'text_indo' => 'UPA Bahasa merupakan salah satu unit kerja penunjang akademik di Politeknik Negeri Malang yang dibentuk untuk mendukung visi, misi dan tujuan Politeknik Negeri Malang terutama dalam kaitannya dengan kompetensi Bahasa. Berbagai kegiatan yang dilakukan UPA Bahasa selama ini berkaitan dengan kebahasaan dan pengajaran bahasa, misalnya tes kemampuan bahasa asing, kursus bahasa, dan juga workshop yang bertujuan meningkatkan pengembangan diri dosen bahasa dan kurikulum pengajaran bahasa di Politeknik Negeri Malang.',
                'text_english' => 'UPA Bahasa is one of the academic support work units at the Malang State Polytechnic which was formed to support the vision, mission and objectives of the Malang State Polytechnic, especially in relation to language competency. Various activities carried out by UPA Bahasa have been related to languages ​​and language teaching, for example foreign language proficiency tests, language courses, and also workshops aimed at improving the self-development of language lecturers and the language teaching curriculum at Malang State Polytechnic.',
                'image_name' => 'default-profil.png',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'program',
                'title_indo' => 'Pelaksanaan Kursus',
                'title_english' => 'Course',
                'text_indo' => 'Program UPA Bahasa ini memberikan kesempatan pada mahasiswa Politeknik Negeri Malang untuk meningkatkan kemampuan bahasa. Melalui program kursus, UPA Bahasa membantu persiapan tes kemampuan bahasa asing seperti TOEIC, TOEFL dan IELTS agar meraih skor yang ditargetkan. Program ini juga memfasilitasi kursus bahasa lainnya seperti Bahasa Jepang, Mandaris, Perancis dan BIPA (Bahasa Indonesia bagi Penutur Asing).',
                'text_english' => 'UPA Bahasa Program provides Malang State Polytechnic students with the opportunity to improve their language skills. Through the course program, UPA Bahasa helps prepare for foreign language proficiency tests such as TOEIC, TOEFL and IELTS in order to achieve the target score. This program also facilitates other language courses such as Japanese, Mandarin, French and BIPA (Indonesian for Foreign Speakers).',
                'image_name' => 'default-pelaksanaan-kursus.jpg',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'program',
                'title_indo' => 'Layanan Penerjemahan dan Penyuntingan',
                'title_english' => 'Translation and Editing Services',
                'text_indo' => 'UPA Bahasa menyediakan solusi komprehensif untuk memenuhi kebutuhan penerjemahan dan penyuntingan teks. UPA Bahasa memiliki tim ahli penerjemahan profesional dan terlatih untuk menghadirkan layanan berkualitas dan akurat sehingga hasil penerjemahan serta penyuntingan dapat dipahami dengan lebih mudah dan akurat.',
                'text_english' => 'UPA Bahasa provides comprehensive solutions to meet translation and text editing needs. UPA Bahasa has a team of professional and trained translation experts to provide quality and accurate services so that translation and editing results can be understood more easily and accurately.',
                'image_name' => 'default-penerjemahan.jpg',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'program',
                'title_indo' => 'Tes Kompetensi Bahasa Inggris',
                'title_english' => 'English Competency Test',
                'text_indo' => 'UPA Bahasa menyediakan layanan tes TOEIC (Test of English for International Communication)  bekerja sama dengan ITC (International Test Center) sebagai pelaksana TOEIC International. Tes TOEIC digunakan untuk mengukur kemampuan komunikasi sehari-hari menggunakan bahasa Inggris yang efektif. Test ini terutama diberikan kepada mahasiswa tingkat akhir dan mahasiswa yang akan mengikuti  program pertukaran pelajar, misalnya IISMA (Indonesian International Student Mobility Awards), joint degre,  atau double degree.',
                'text_english' => 'UPA Bahasa provides TOEIC (Test of English for International Communication) test services in collaboration with ITC (International Test Center) as the implementer of TOEIC International. The TOEIC test is used to measure daily communication skills using effective English. This test is mainly given to final year students and students who will take part in student exchange programs, for example IISMA (Indonesian International Student Mobility Awards), joint degree, or double degree.',
                'image_name' => 'default-Kompetensi.jpg',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'program',
                'title_indo' => 'Pengembangan Kompetensi Bahasa Asing Mandiri',
                'title_english' => 'Independent Development of Foreign Language Competency',
                'text_indo' => 'UPA Bahasa memiliki program pengembangan kompetensi bahasa asing mandiri (Self Access Center/SAC). SAC merupakan fasilitas belajar yang dirancang untuk memberikan kesempatan pada mahasiswa mengembangkan kemampuan bahasanya secara mandiri di luar pembelajaran reguler dalam kelas. Dengan Standar Operasional Prosedur (SOP) dan jadwal yang fleksibel, mahasiswa dapat menyesuaikan waktu menggunakan fasilitas tersebut sesuai kebutuhan dan waktu yang disediakan.',
                'text_english' => 'UPA Bahasa has an independent foreign language competency development program (Self Access Center/SAC). SAC is a learning facility designed to provide students with the opportunity to develop their language skills independently outside of regular classroom learning. With Standard Operating Procedures (SOP) and flexible schedules, students can adjust their time using these facilities according to their needs and the time available.',
                'image_name' => 'default-pengembangan.jpg',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'program',
                'title_indo' => 'Konsultasi Individu',
                'title_english' => 'Individual Consultation',
                'text_indo' => 'UPA Bahasa menyediakan layanan konsultasi penulisan artikel ilmiah dalam bahasa Inggris untuk dosen yang sedang studi doctoral dan mahasiswa magister.',
                'text_english' => 'UPA Bahasa provides consultation services for writing scientific articles in English for lecturers who are currently studying doctoral studies and masters students.',
                'image_name' => 'default-konsultasi.jpg',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'program',
                'title_indo' => 'Pelatihan Bahasa Inggris bagi Pengajar Internasional',
                'title_english' => 'English Language Training for International Teachers',
                'text_indo' => 'UPA Bahasa memiliki program pelatihan bahasa Inggris yang diberikan kepada pengajar kelas internasional dan tenaga kependidikan di berbagai jurusan. Selain itu, program ini dirancang untuk memberikan dukungan dan pengembangan kemampuan bahasa Inggris kepada pengajar kelas internasional (selain pengampu matakuliah Bahasa Inggris) sehingga dapat berkomunikasi dan menyampaikan materi dengan lebih mudah dan tepat.',
                'text_english' => 'UPA Bahasa has an English language training program provided to international class teachers and education staff in various departments. In addition, this program is designed to provide support and development of English language skills to international class teachers (aside from those teaching English courses) so that they can communicate and deliver material more easily and accurately.',
                'image_name' => 'default-pelatihan.jpg',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
