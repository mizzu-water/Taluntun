
    <script>
        const { createApp, ref, onMounted } = Vue;

        createApp({
            setup() {
                const courseName = ref("Loading Course...");
                const currentTab = ref("intro");
                const quizAnswer = ref(null);
                const courseData = ref({
                    videoUrl: "https://www.youtube.com/embed/dQw4w9WgXcQ", // Generic video or empty
                    subjects: [
                        { title: "Core Fundamentals", desc: "Learn the foundational principles and theories." },
                        { title: "Advanced Applications", desc: "Apply knowledge to real-world complex scenarios." },
                        { title: "Industry Standard Tools", desc: "Master the software and equipment used by professionals." },
                        { title: "Capstone Project", desc: "A comprehensive final project showcasing your skills." }
                    ],
                    careers: [
                        { role: "Junior Specialist", salary: "?20,000 - ?30,000", desc: "Entry-level position focusing on execution and support." },
                        { role: "Senior Analyst", salary: "?40,000 - ?70,000", desc: "Mid-level role requiring strategic thinking and leadership." },
                        { role: "Department Manager", salary: "?80,000+", desc: "Executive role overseeing operations and team performance." }
                    ],
                    workflow: [
                        { title: "Discovery", desc: "Identifying the core problems and requirements." },
                        { title: "Planning", desc: "Developing a strategic roadmap." },
                        { title: "Execution", desc: "Implementing the solution efficiently." },
                        { title: "Review", desc: "Analyzing results and optimizing for the future." }
                    ],
                    quiz: {
                        question: "What is the primary focus of this field?",
                        options: ["Solving Problems", "Memorizing Facts", "Repetitive Tasks"],
                        answerIndex: 0,
                        explanation: "This discipline heavily relies on critical thinking and problem-solving methodologies."
                    }
                });

                const tabs = ["intro", "learn", "careers", "basics", "try"];
                const nextTab = () => {
                    const idx = tabs.indexOf(currentTab.value);
                    if (idx < tabs.length - 1) currentTab.value = tabs[idx + 1];
                };
                const prevTab = () => {
                    const idx = tabs.indexOf(currentTab.value);
                    if (idx > 0) currentTab.value = tabs[idx - 1];
                };

                onMounted(async () => {
                    const params = new URLSearchParams(window.location.search);
                    const courseId = params.get("id");
                    
                    if (courseId) {
                        try {
                            const res = await fetch(`/riasec/get_degree.php?id=${courseId}`);
                            const data = await res.json();
                            if (data && data.title) {
                                courseName.value = data.title;
                                
                                // Customize mock data based on category if desired
                                if (data.category === "engineering") {
                                    courseData.value.quiz.question = "Which is critical in Engineering?";
                                    courseData.value.quiz.options = ["Design & Logic", "Artistic Expression", "Public Speaking"];
                                    courseData.value.quiz.answerIndex = 0;
                                    courseData.value.quiz.explanation = "Engineering requires logical problem solving and precise design.";
                                }
                            }
                        } catch (e) {
                            console.error("Error fetching course data:", e);
                            courseName.value = "Unknown Course";
                        }
                    } else {
                        courseName.value = "General Program Overview";
                    }
                });

                return {
                    courseName,
                    currentTab,
                    courseData,
                    quizAnswer,
                    nextTab,
                    prevTab
                };
            }
        }).mount("#app");
    </script>

