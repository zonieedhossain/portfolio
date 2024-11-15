package main

import (
	"encoding/json"
	"html/template"
	"log"
	"net/http"
	"time"
)

type Response struct {
	Status int         `json:"status"`
	Time   float64     `json:"time"`
	Data   interface{} `json:"data"`
}

var summary = []string{"I am a Senior Software Engineer with a deep passion for Golang and microservices architecture. Throughout my career, I have been dedicated to building scalable, efficient, and robust solutions, with a strong focus on system performance and reliability. My approach is driven by a Site Reliability Engineering (SRE) mindset, where I prioritize optimizing low-latency communication, ensuring high availability, and delivering systems that perform seamlessly at scale."}

//"Since the beginning of my career, I have been working extensively with Golang, which has allowed me to build systems that are not only efficient but also maintainable and easy to scale. My expertise extends to designing and developing microservices that leverage cutting-edge tools and technologies, enabling businesses to achieve greater agility, flexibility, and performance.",
//
//"I have a strong foundation in cloud platforms like Google Cloud Platform (GCP) and Amazon Web Services (AWS), and I am proficient in using containerization technologies such as Docker and orchestration tools like Kubernetes to ensure seamless deployment and scalability of applications. I am also experienced with relational databases, particularly PostgreSQL, and have worked with messaging systems such as RabbitMQ for handling high-throughput and distributed workloads.",

var experience = []struct {
	Company      string   `json:"company"`
	Title        string   `json:"title"`
	Period       string   `json:"period"`
	Description  string   `json:"description"`
	Achievements []string `json:"achievements"`
	Skills       []string `json:"skills"`
}{
	{
		Company:     "Gononet Online Solution Limited",
		Title:       "Senior Software Engineer, Team Lead",
		Period:      "08/2024 - Present",
		Description: "Currently leading a team of 9 engineers to build the MVP for the GonoERP system.",
		Achievements: []string{
			"Designing and implementing an API server and 8 microservices using Golang, PostgreSQL, gRPC, GraphQL, and RabbitMQ",
			"Integrating Grafana and Loki to enhance monitoring and reduce error resolution time",
			"Collaborated with the DevOps team to successfully deploy GonoERP on Kubernetes",
			"Mentoring 3 engineers, supporting their career growth and helping them navigate challenges",
		},
		Skills: []string{"Golang", "PostgreSQL", "gRPC", "GraphQL", "RabbitMQ", "Kubernetes"},
	},
	{
		Company:     "Shikho Technologies Bangladesh Limited",
		Title:       "SDE-II Golang Engineer, Core Infra",
		Period:      "12/2021 - 07/2024",
		Description: "Collaborated with the core backend team to develop microservices for Shikho.",
		Achievements: []string{
			"Developed 10 microservices for Shikho's core platform",
			"Contributed to the AQL query builder, speeding up development by 50%",
			"Optimized GraphQL Dataloader, improving system performance",
			"Replaced RabbitMQ with a custom queue system, reducing operational costs",
			"Developed data pipelines processing 1.5 GB daily from MongoDB to PostgreSQL",
			"Designed and implemented a flexible coupon system",
			"Migrated Bohubrihi WordPress site to 7 microservices",
		},
		Skills: []string{"Golang", "GraphQL", "MongoDB", "PostgreSQL", "Microservices"},
	},
	{
		Company:     "Code Concept Consulting",
		Title:       "Software Consultant (Part-Time)",
		Period:      "02/2022 - 05/2024",
		Description: "Handled international clients including USA-based JL Audio.",
		Achievements: []string{
			"Integrated Golang middleware with Python admin panel",
			"Deployed infrastructure using Terraform for 2 projects",
			"Maintained TDD practices across codebases",
			"Built Warehouse Management System for Shopify",
			"Improved system uptime post-redeployment",
		},
		Skills: []string{"Golang", "Python", "PostgreSQL", "Terraform", "TDD", "Shopify"},
	},
	{
		Company:     "Ghuri Express Limited",
		Title:       "Senior Software Engineer, Team Lead",
		Period:      "06/2021 - 12/2021",
		Description: "Led development team for Parcel Delivery and E-commerce systems.",
		Achievements: []string{
			"Led team of 8 engineers",
			"Built E-commerce platform with 4 microservices",
			"Created Parcel Order System handling 10,000 orders via Excel",
			"Implemented real-time rider tracking",
			"Mentored 5 junior developers",
		},
		Skills: []string{"Golang", "MySQL", "Redis", "Docker", "Kubernetes", "Microservices"},
	},
	{
		Company:     "Ghuri Express Limited",
		Title:       "Software Engineer",
		Period:      "02/2021 - 05/2021",
		Description: "Planned and designed the Parcel Delivery System with 5 microservices using Golang, MySQL, and Redis per company requirements.",
		Achievements: []string{
			"Automated deployment processes, significantly reducing deployment time using Docker and Kubernetes",
			"Launched the delivery system 3 months before the deadline",
		},
		Skills: []string{"Golang", "MySQL", "Redis", "Docker", "Kubernetes", "Microservices"},
	},
	{
		Company:     "Sticker Driver Limited",
		Title:       "Software Developer (Backend)",
		Period:      "06/2019 - 02/2021",
		Description: "Sticker Driver Limited is Bangladesh's first out-of-home advertising tech startup, offering a range of advertising services, including on-vehicle and traditional outdoor advertising.",
		Achievements: []string{
			"Built a car tracking system, impacting 1,500+ users daily",
			"Implemented a route reduction algorithm, decreasing routing costs",
			"Built a manual route drawing system, saving the company approximately $5,475 per month",
		},
		Skills: []string{},
	},
	{
		Company:     "Avalon Hosting Services Limited",
		Title:       "Intern Front-End Web Developer",
		Period:      "01/2019 - 05/2019",
		Description: "Avalon Hosting Services Ltd is a USA-based provider, offers fast, reliable, and scalable cloud and dedicated server solutions.",
		Achievements: []string{
			"Worked on a school management system",
			"Optimized WordPress website performance",
			"Designed page layouts and UIs for 10 web page",
		},
		Skills: []string{"WordPress", "UI Design"},
	},
}
var projects = []struct {
	Title        string   `json:"title"`
	Description  string   `json:"description"`
	URL          string   `json:"url"`
	Technologies []string `json:"technologies"`
	Github       string   `json:"github,omitempty"`
}{
	{
		Title:        "Bohubrihi",
		Description:  "Bohubrihi is a Bangladeshi online education platform providing professional and technical courses designed to enhance skills in areas like software development, business, design, and more.",
		URL:          "https://www.bohubrihi.com/",
		Technologies: []string{"Golang", "Microservices", "PostgreSQL", "GraphQL", "Docker", "Kubernetes"},
	},
	{
		Title:        "JL Audio",
		Description:  "JL Audio is an American manufacturer of consumer audio products. Integrated Golang middleware with Python admin panel using PostgreSQL, integrated with Simplex and Dynamics 365 systems.",
		URL:          "https://www.jlaudio.com/",
		Technologies: []string{"Golang", "Python", "PostgreSQL", "Terraform"},
	},
	{
		Title:        "CarAds",
		Description:  "CarAds is an OOH Ad-Tech startup in Bangladesh, specializing in advertising technology. It connects brands with audiences through innovative outdoor advertising solutions.",
		URL:          "https://www.carads.com.bd/",
		Technologies: []string{"Golang", "PostgreSQL", "Docker", "Kubernetes"},
	},
	{
		Title:        "DM Bot",
		Description:  "A bot created to automate repetitive messaging in a Discord channel. Designed to automate direct messaging in high-traffic scenarios.",
		Github:       "https://github.com/zonieedhossain/dmbot",
		Technologies: []string{"Python", "Discord API", "Automation"},
	},
}

var skills = []struct {
	Category string   `json:"category"`
	Items    []string `json:"items"`
}{
	{
		Category: "Programming Languages & Frameworks",
		Items: []string{
			"Golang", "Python", "Django", "Fiber", "Gin", "Echo",
			"Gorm", "Mux", "Bun", "HTML", "CSS", "Bootstrap",
			"JavaScript", "jQuery", "Laravel",
		},
	},
	{
		Category: "Databases",
		Items: []string{
			"MySQL", "PostgreSQL", "Redis", "MongoDB",
			"ArangoDB", "Oracle", "Elasticsearch",
		},
	},
	{
		Category: "APIs & Protocols",
		Items: []string{
			"gRPC", "GraphQL", "REST", "Google Maps API",
		},
	},
	{
		Category: "DevOps & Infrastructure",
		Items: []string{
			"AWS", "GCP", "Digital Ocean", "Docker",
			"Kubernetes", "Terraform",
		},
	},
	{
		Category: "Other Technologies",
		Items: []string{
			"Event-Driven Architecture", "RabbitMQ", "NATS",
			"Asynq", "Karate", "WordPress", "Auth0", "JWT",
		},
	},
}

var education = struct {
	Education struct {
		Degree      string `json:"degree"`
		Institution string `json:"institution"`
		Period      string `json:"period"`
		GPA         string `json:"gpa"`
	} `json:"education"`
	Certifications []string `json:"certifications"`
}{
	Education: struct {
		Degree      string `json:"degree"`
		Institution string `json:"institution"`
		Period      string `json:"period"`
		GPA         string `json:"gpa"`
	}{
		Degree:      "B.Sc. in Computer Science and Engineering",
		Institution: "University of Asia Pacific",
		Period:      "2015 - 2018",
		GPA:         "",
	},
	Certifications: []string{
		"The 2016 ACM-ICPC Asia Dhaka Regional Contest",
		"The 2016 ACM-ICPC Bangladesh National Collegiate Programming Contest",
	},
}

var publications = []struct {
	Title     string   `json:"title"`
	Publisher string   `json:"publisher"`
	Date      string   `json:"date"`
	URL       string   `json:"url"`
	Authors   []string `json:"authors"`
}{
	{
		Title:     "Character and Mesh Optimization of Modern 3D Video Games",
		Publisher: "Springer Singapore",
		Date:      "01/2020",
		URL:       "https://link.springer.com/chapter/10.1007/978-981-15-0694-9_60",
		Authors: []string{
			"Ragib Hasan", "Sumittra Chakraborti", "Md. Zonieed Hossain",
			"Taukir Ahamed", "Md. Abdul Hamid", "M. F. Mridha",
		},
	},
}

func handleResponse(w http.ResponseWriter, data interface{}) {
	w.Header().Set("Content-Type", "application/json")
	response := Response{
		Status: 200,
		Time:   float64(time.Now().UnixNano()) / 1e6,
		Data:   data,
	}
	json.NewEncoder(w).Encode(response)
}

func main() {
	// Serve static files
	fs := http.FileServer(http.Dir("static"))
	http.Handle("/static/", http.StripPrefix("/static/", fs))

	// Main page
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		tmpl := template.Must(template.ParseFiles("templates/index.html"))
		tmpl.Execute(w, nil)
	})

	// API endpoints
	http.HandleFunc("/api/summary", func(w http.ResponseWriter, r *http.Request) {
		handleResponse(w, summary)
	})

	http.HandleFunc("/api/experience", func(w http.ResponseWriter, r *http.Request) {
		handleResponse(w, experience)
	})

	http.HandleFunc("/api/projects", func(w http.ResponseWriter, r *http.Request) {
		handleResponse(w, projects)
	})

	http.HandleFunc("/api/skills", func(w http.ResponseWriter, r *http.Request) {
		handleResponse(w, skills)
	})

	http.HandleFunc("/api/education", func(w http.ResponseWriter, r *http.Request) {
		handleResponse(w, education)
	})

	http.HandleFunc("/api/publications", func(w http.ResponseWriter, r *http.Request) {
		handleResponse(w, publications)
	})

	log.Println("Server starting on :8080...")
	log.Fatal(http.ListenAndServe(":8080", nil))
}
