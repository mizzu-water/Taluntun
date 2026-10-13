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
    public function pcuProfile() { $this->view('pcu-profile'); }
    public function pcuCampus() { $this->view('pcu-campus'); }
    public function pcuPrograms() { $this->view('pcu-programs'); }
    public function pcuTuition() { $this->view('pcu-tuition'); }

    // TUP Pages
    public function tupProfile() { $this->view('tup-profile'); }
    public function tupCampus() { $this->view('tup-campus'); }
    public function tupPrograms() { $this->view('tup-programs'); }
    public function tupTuition() { $this->view('tup-tuition'); }

        // CVSU Pages
    public function cvsuProfile() { $this->view('cvsu-profile'); }
    public function cvsuCampus() { $this->view('cvsu-campus'); }
    public function cvsuPrograms() { $this->view('cvsu-programs'); }
    public function cvsuTuition() { $this->view('cvsu-tuition'); }

        // DLSU Pages
    public function dlsuProfile() { $this->view('dlsu-profile'); }
    public function dlsuCampus() { $this->view('dlsu-campus'); }
    public function dlsuPrograms() { $this->view('dlsu-programs'); }
    public function dlsuTuition() { $this->view('dlsu-tuition'); }

        // EAC Pages
    public function eacProfile() { $this->view('eac-profile'); }
    public function eacCampus() { $this->view('eac-campus'); }
    public function eacPrograms() { $this->view('eac-programs'); }
    public function eacTuition() { $this->view('eac-tuition'); }

        // NCST Pages
    public function ncstProfile() { $this->view('ncst-profile'); }
    public function ncstCampus() { $this->view('ncst-campus'); }
    public function ncstPrograms() { $this->view('ncst-programs'); }
    public function ncstTuition() { $this->view('ncst-tuition'); }

    // Generic School Pages
    public function schoolProfile() { $this->view('school-profile'); }
    public function schoolCampus() { $this->view('school-campus'); }
    public function schoolPrograms() { $this->view('school-programs'); }
    public function schoolTuition() { $this->view('school-tuition'); }

    // Admin & Details
    public function admin() { $this->view('admin'); }
    public function details() { $this->view('details'); }
}


