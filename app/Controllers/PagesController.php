<?php
class PagesController extends Controller {
    public function careers() { $this->view('degrees'); }
    public function colleges() { $this->view('colleges'); }
    public function degrees() { $this->view('degrees'); }
    public function degreeProfile() { $this->view('degree-profile'); }
    public function lesson() { $this->view('lesson'); }
    public function scholarships() { $this->view('scholarships'); }
    public function schoolMap() { $this->view('school-map'); }
    
        public function howItWorks() { $this->view('how-it-works'); }
    public function holland() { $this->view('holland'); }
    public function courseIntro() { $this->view('course-intro'); }

    // PCU Pages
    public function pcuProfile() { $this->view('pcu-profile', ['title' => 'Philippine Christian University (PCU) - Talunton Cavite']); }
    public function pcuCampus() { $this->view('pcu-campus', ['title' => 'PCU Campus Grounds - Talunton Cavite']); }
    public function pcuPrograms() { $this->view('pcu-programs', ['title' => 'PCU Programs Offered - Talunton Cavite']); }
    public function pcuTuition() { $this->view('pcu-tuition', ['title' => 'PCU Tuition & Fees - Talunton Cavite']); }

    // TUP Pages
    public function tupProfile() { $this->view('tup-profile', ['title' => 'Technological University of the Philippines (TUP) - Talunton Cavite']); }
    public function tupCampus() { $this->view('tup-campus', ['title' => 'TUP Campus Grounds - Talunton Cavite']); }
    public function tupPrograms() { $this->view('tup-programs', ['title' => 'TUP Programs Offered - Talunton Cavite']); }
    public function tupTuition() { $this->view('tup-tuition', ['title' => 'TUP Tuition & Fees - Talunton Cavite']); }

    // CVSU Pages
    public function cvsuProfile() { $this->view('cvsu-profile', ['title' => 'Cavite State University (CvSU) - Talunton Cavite']); }
    public function cvsuCampus() { $this->view('cvsu-campus', ['title' => 'CvSU Campus Grounds - Talunton Cavite']); }
    public function cvsuPrograms() { $this->view('cvsu-programs', ['title' => 'CvSU Programs Offered - Talunton Cavite']); }
    public function cvsuTuition() { $this->view('cvsu-tuition', ['title' => 'CvSU Tuition & Fees - Talunton Cavite']); }

    // DLSU Pages
    public function dlsuProfile() { $this->view('dlsu-profile', ['title' => 'De La Salle University - Dasmariñas (DLSU-D) - Talunton Cavite']); }
    public function dlsuCampus() { $this->view('dlsu-campus', ['title' => 'DLSU-D Campus Grounds - Talunton Cavite']); }
    public function dlsuPrograms() { $this->view('dlsu-programs', ['title' => 'DLSU-D Programs Offered - Talunton Cavite']); }
    public function dlsuTuition() { $this->view('dlsu-tuition', ['title' => 'DLSU-D Tuition & Fees - Talunton Cavite']); }

    // EAC Pages
    public function eacProfile() { $this->view('eac-profile', ['title' => 'Emilio Aguinaldo College - Cavite (EAC-C) - Talunton Cavite']); }
    public function eacCampus() { $this->view('eac-campus', ['title' => 'EAC-C Campus Grounds - Talunton Cavite']); }
    public function eacPrograms() { $this->view('eac-programs', ['title' => 'EAC-C Programs Offered - Talunton Cavite']); }
    public function eacTuition() { $this->view('eac-tuition', ['title' => 'EAC-C Tuition & Fees - Talunton Cavite']); }

    // NCST Pages
    public function ncstProfile() { $this->view('ncst-profile', ['title' => 'National College of Science and Technology (NCST) - Talunton Cavite']); }
    public function ncstCampus() { $this->view('ncst-campus', ['title' => 'NCST Campus Grounds - Talunton Cavite']); }
    public function ncstPrograms() { $this->view('ncst-programs', ['title' => 'NCST Programs Offered - Talunton Cavite']); }
    public function ncstTuition() { $this->view('ncst-tuition', ['title' => 'NCST Tuition & Fees - Talunton Cavite']); }

    // Generic School Pages
    public function schoolProfile() { $this->view('school-profile'); }
    public function schoolCampus() { $this->view('school-campus'); }
    public function schoolPrograms() { $this->view('school-programs'); }
    public function schoolTuition() { $this->view('school-tuition'); }

    // Admin & Details
    public function admin() { $this->view('admin'); }
    public function details() { $this->view('details'); }
}


