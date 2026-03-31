package main

import (
	"encoding/json"
	"fmt"
	"html/template"
	"log"
	"math/rand"
	"net/http"
	"net/http/cgi"
	"os"
	"path/filepath"
	"strings"
	"time"
)

type Response struct {
	Status int         `json:"status"`
	Time   float64     `json:"time"`
	Data   interface{} `json:"data"`
}

var summary = []string{
	"👋 Hi, I’m Zonieed. I am a Senior Software Engineer with a deep passion for Golang and microservices architecture.",
	"Throughout my career, I have been dedicated to building scalable, efficient and robust solutions. My approach is rooted in a Site Reliability Engineering (SRE) mindset—prioritizing low-latency communication, specific performance optimizations and high availability to ensure systems perform seamlessly at scale.",
	"With over 7 years of experience across ERP, logistics and EdTech domains, I specialize in turning complex business problems into clean, reliable software. I’ve designed stock tracking engines, built fault-tolerant integrations, migrated legacy monoliths to microservices and led teams through production-grade system design.",
	"I care deeply about system clarity, correctness and long-term maintainability. Beyond just writing code, I enjoy mentoring engineers, reviewing designs and helping teams cultivate a culture of engineering excellence.",
	"📍 Based in Dhaka, Bangladesh — open to global opportunities.",
}

var experience = []struct {
	Company      string   `json:"company"`
	Title        string   `json:"title"`
	Period       string   `json:"period"`
	Description  string   `json:"description"`
	Achievements []string `json:"achievements"`
	Skills       []string `json:"skills"`
}{
	{
		Company:     "Gononet Online Solutions Limited",
		Title:       "Senior Software Engineer, Team Lead",
		Period:      "August 2024 - Present",
		Description: "Leading backend development for enterprise ERP and grocery delivery platforms.",
		Achievements: []string{
			"Designed and maintained core ERP services (user management, sales, purchase, inventory, authentication, API gateway)",
			"Built stock tracking engine with bin-level warehouse logic to improve inventory efficiency and lookup performance",
			"Implemented RBAC/ABAC security models for multi-tenant environments",
			"Developed vendor discovery and SLA-based routing logic for grocery delivery platform",
			"Automated vendor onboarding and zone allocation workflows",
			"Mentored junior engineers and conducted code/design reviews",
		},
		Skills: []string{"Golang", "PostgreSQL", "gRPC", "Kafka", "Docker", "Kubernetes"},
	},
	{
		Company:     "Shikho Technologies Bangladesh Limited",
		Title:       "SDE-II Golang Engineer, Core Infrastructure",
		Period:      "December 2021 - July 2024",
		Description: "Built core backend infrastructure for Bangladesh's leading EdTech platform.",
		Achievements: []string{
			"Developed exam orchestration and live-exam systems handling concurrent user loads",
			"Created data pipelines synchronizing learning, reporting and KPI systems",
			"Enhanced course management, enrollment and affiliate modules",
			"Implemented asynchronous workflows using message queues for reliable event processing",
			"Migrated Bohubrihi (professional learning platform) from WordPress monolith to Golang microservices",
			"Built features for gateway, certification and analytics services",
			"Automated data synchronization and certificate issuance workflows",
		},
		Skills: []string{"Golang", "PostgreSQL", "MongoDB", "Kafka", "gRPC", "Docker", "Microservices"},
	},
	{
		Company:     "Code Concept Consulting (JL Audio / Garmin)",
		Title:       "Software Consultant (Contractual, Part-Time)",
		Period:      "February 2022 - May 2024",
		Description: "Backend consulting for international clients including JL Audio and Garmin.",
		Achievements: []string{
			"Built middleware in Go and Python integrating Shopify with Microsoft Dynamics 365",
			"Designed fault-tolerant API integrations with retry logic, logging and idempotent operations",
			"Implemented delta updates and webhook listeners for real-time synchronization",
			"Developed WMS features for Shopify and optimized batch data handling",
			"Created Python/Django admin dashboard for integration monitoring",
			"Deployed infrastructure using Terraform on cloud platforms",
		},
		Skills: []string{"Golang", "Python", "Django", "PostgreSQL", "Terraform", "AWS"},
	},
	{
		Company:     "Ghuri Express Limited",
		Title:       "Senior Software Engineer, Team Lead",
		Period:      "June 2021 - December 2021",
		Description: "Led backend development for logistics and quick-commerce delivery platform.",
		Achievements: []string{
			"Designed zone-aware dispatch logic with geo-indexing and SLA-based routing",
			"Implemented real-time rider tracking using Redis pub/sub and WebSockets",
			"Built merchant onboarding workflows and control panel APIs",
			"Optimized PostgreSQL queries and implemented caching strategies with Redis",
			"Added monitoring and observability with Prometheus and Grafana",
		},
		Skills: []string{"Golang", "PostgreSQL", "Redis", "WebSockets", "Docker", "Kubernetes"},
	},
	{
		Company:     "Ghuri Express Limited",
		Title:       "Software Engineer (Backend)",
		Period:      "February 2021 - May 2021",
		Description: "Designed and launched parcel delivery system with microservices architecture.",
		Achievements: []string{
			"Built 5-microservice delivery system from scratch",
			"Automated deployment pipelines using Docker and Kubernetes",
			"Launched complete delivery platform 3 months ahead of schedule",
		},
		Skills: []string{"Golang", "PostgreSQL", "Redis", "Docker", "Kubernetes"},
	},
	{
		Company:     "Adeffi (formerly Sticker Driver Limited)",
		Title:       "Software Developer (Backend)",
		Period:      "June 2019 - February 2021",
		Description: "Built backend services for vehicle advertising and campaign management platform.",
		Achievements: []string{
			"Developed Golang microservices for campaign lifecycle, billing, driver tracking and reporting",
			"Integrated mapping APIs with optimized distance calculations and static map rendering",
			"Improved API response times through caching and query optimization",
			"Deployed services on Kubernetes and Google Cloud Platform",
			"Built campaign data pipelines and contributed to CI/CD workflows",
		},
		Skills: []string{"Golang", "PostgreSQL", "Redis", "Docker", "GCP", "Kubernetes"},
	},
	{
		Company:     "Avalon Hosting Services Limited",
		Title:       "Intern Front-End Web Developer",
		Period:      "January 2019 - May 2019",
		Description: "Frontend development internship at USA-based hosting provider.",
		Achievements: []string{
			"Improved responsive layouts and fixed cross-browser compatibility issues",
			"Enhanced template modularity using HTML, CSS and JavaScript",
			"Collaborated with senior developers on UI improvements and documentation",
		},
		Skills: []string{"HTML", "CSS", "JavaScript"},
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
		Title:        "GonoERP (RetailerBook)",
		Description:  "Enterprise ERP platform for procurement, sales, inventory management and demand planning. Built with microservices architecture featuring user management, authentication, sales, purchase and inventory modules with advanced stock tracking using warehouse bin logic.",
		Technologies: []string{"Golang", "PostgreSQL", "gRPC", "Kafka", "Docker", "Kubernetes"},
	},
	{
		Title:        "JL Audio / Garmin Middleware",
		Description:  "Integration platform synchronizing Shopify orders and inventory with Microsoft Dynamics 365. Features fault-tolerant APIs with retry logic, webhook listeners, delta updates and real-time data synchronization for enterprise e-commerce operations.",
		URL:          "https://www.jlaudio.com/",
		Technologies: []string{"Golang", "Python", "Django", "PostgreSQL", "Terraform", "AWS"},
	},
	{
		Title:        "Shikho EdTech Platform",
		Description:  "National curriculum EdTech platform with exam orchestration, live exams, data pipelines, course management and large-scale learner engagement. Handles concurrent users with event-driven architecture and real-time analytics.",
		Technologies: []string{"Golang", "PostgreSQL", "MongoDB", "Kafka", "gRPC", "Microservices"},
	},
	{
		Title:        "Bohubrihi Learning Platform",
		Description:  "Professional learning platform migrated from WordPress monolith to Golang microservices. Features course management, enrollment systems, certification workflows and analytics for scalable content delivery.",
		URL:          "https://www.bohubrihi.com/",
		Technologies: []string{"Golang", "PostgreSQL", "Microservices", "Docker", "Kubernetes"},
	},
	{
		Title:        "Ghuri Express Logistics",
		Description:  "Real-time logistics and quick-commerce platform with zone-aware dispatching, SLA-based routing, rider tracking using WebSockets, merchant onboarding and control panel for operations management.",
		Technologies: []string{"Golang", "PostgreSQL", "Redis", "WebSockets", "Docker", "Kubernetes"},
	},
	{
		Title:        "GorillaMove Grocery Delivery",
		Description:  "Grocery delivery backend with vendor discovery, automated zone allocation, SLA-based routing and vendor onboarding workflows. Optimized for fast fulfillment and operational efficiency.",
		Technologies: []string{"Golang", "PostgreSQL", "gRPC", "Kafka", "Docker"},
	},
	{
		Title:        "Sticker Driver / CarAds",
		Description:  "Vehicle advertising platform with geo-targeted campaign management, driver tracking, billing systems and optimized mapping integrations. Features distance-based campaign logic and static map rendering for cost efficiency.",
		URL:          "https://www.carads.com.bd/",
		Technologies: []string{"Golang", "PostgreSQL", "Redis", "Docker", "GCP"},
	},
}

var skills = []struct {
	Category string   `json:"category"`
	Items    []string `json:"items"`
}{
	{
		Category: "Programming Languages",
		Items:    []string{"Golang (Go)", "Python"},
	},
	{
		Category: "Frameworks & Libraries",
		Items:    []string{"Gin", "Fiber", "Echo", "Django", "GORM"},
	},
	{
		Category: "Databases & Caching",
		Items:    []string{"PostgreSQL", "MongoDB", "MySQL", "ArangoDB", "Redis"},
	},
	{
		Category: "Messaging & Streaming",
		Items:    []string{"Apache Kafka", "NATS", "RabbitMQ"},
	},
	{
		Category: "APIs & Communication",
		Items:    []string{"gRPC", "REST", "GraphQL"},
	},
	{
		Category: "Cloud & DevOps",
		Items:    []string{"Docker", "Kubernetes", "AWS", "GCP", "Terraform", "Linux"},
	},
	{
		Category: "Architecture & System Design",
		Items: []string{
			"Microservices Architecture",
			"Event-Driven Architecture",
			"Domain-Driven Design (DDD)",
		},
	},
	{
		Category: "Observability & Tooling",
		Items:    []string{"Git", "Prometheus", "Grafana"},
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
		Degree:      "Bachelor of Science in Computer Science and Engineering",
		Institution: "University of Asia Pacific",
		Period:      "2015 - 2018",
		GPA:         "",
	},
	Certifications: []string{
		"The 2016 ACM-ICPC Asia Dhaka Regional Contest - University of Asia Pacific",
		"The 2016 ACM-ICPC Bangladesh National Collegiate Programming Contest - University of Asia Pacific",
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
		Publisher: "Springer Singapore - 2nd International Conference on Data & Information Sciences",
		Date:      "January 2020",
		URL:       "https://link.springer.com/chapter/10.1007/978-981-15-0694-9_60",
		Authors: []string{
			"Md. Zonieed Hossain", "Ragib Hasan", "Sumittra Chakraborti",
			"Taukir Ahamed", "Md. Abdul Hamid", "M. F. Mridha",
		},
	},
}

func handleSystemStats(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")
	w.Header().Set("Access-Control-Allow-Origin", "*")
	w.Header().Set("Access-Control-Allow-Methods", "GET, POST, OPTIONS")
	w.Header().Set("Access-Control-Allow-Headers", "Content-Type")

	// Seed random for realistic variations
	rand.Seed(time.Now().UnixNano())

	// Generate realistic system stats
	stats := map[string]interface{}{
		"time":     time.Now().Format("15:04:05"),
		"date":     time.Now().Format("Monday, January 2, 2006"),
		"location": "Dhaka, Bangladesh",
		"cpu": map[string]interface{}{
			"usage": 15 + rand.Float64()*45, // 15-60% range
			"cores": 8,
		},
		"ram": map[string]interface{}{
			"used":  4096 + rand.Float64()*2048, // 4-6 GB used
			"total": 16384,                      // 16 GB total
			"usage": 25 + rand.Float64()*35,     // 25-60% range
		},
		"network": map[string]interface{}{
			"upload":   rand.Float64() * 500,  // 0-500 KB/s
			"download": rand.Float64() * 2000, // 0-2 MB/s
		},
	}

	response := Response{
		Status: 200,
		Time:   float64(time.Now().UnixNano()) / 1e6,
		Data:   stats,
	}
	json.NewEncoder(w).Encode(response)
}

func handleResponse(w http.ResponseWriter, data interface{}) {
	w.Header().Set("Content-Type", "application/json")
	w.Header().Set("Access-Control-Allow-Origin", "*")
	w.Header().Set("Access-Control-Allow-Methods", "GET, POST, OPTIONS")
	w.Header().Set("Access-Control-Allow-Headers", "Content-Type")

	response := Response{
		Status: 200,
		Time:   float64(time.Now().UnixNano()) / 1e6,
		Data:   data,
	}
	json.NewEncoder(w).Encode(response)
}
func handler(w http.ResponseWriter, r *http.Request) {
	path := r.URL.Path

	// CGI Path Correction: Strip binary name from path if present
	// (e.g., /portfolio.cgi/api/summary -> /api/summary)
	prefixes := []string{"/portfolio.cgi", "/index.cgi", "/main.cgi"}
	for _, pref := range prefixes {
		if strings.HasPrefix(path, pref) {
			path = strings.TrimPrefix(path, pref)
			if path == "" {
				path = "/"
			}
			break
		}
	}

	// Handle static files
	if strings.HasPrefix(path, "/static/") {
		file := filepath.Join(".", path)
		http.ServeFile(w, r, file)
		return
	}

	// Handle API endpoints
	switch path {
	case "/api/summary":
		handleResponse(w, summary)
	case "/api/experience":
		handleResponse(w, experience)
	case "/api/projects":
		handleResponse(w, projects)
	case "/api/skills":
		handleResponse(w, skills)
	case "/api/education":
		handleResponse(w, education)
	case "/api/publications":
		handleResponse(w, publications)
	case "/api/system-stats":
		handleSystemStats(w, r)
	case "/debug":
		fmt.Fprintf(w, "CGI OK - If you see this, the binary is executing correctly.")
	case "/":
		mainHandler(w, r)
	default:
		// In dev mode, /static/ is handled by http.Handle but here we cover it for CGI
		// For other paths, serve index or 404.
		// Since we want SPA-like behavior or just a simple site,
		// unknown paths usually go to mainHandler in many routers,
		// but here we can just default to mainHandler for root
		// or return 404.
		// The original code fell through to mainHandler.
		if path != "/" {
			http.NotFound(w, r)
			return
		}
		mainHandler(w, r)
	}
}

func main() {
	// Ultra-minimal startup test for CGI
	if os.Getenv("GATEWAY_INTERFACE") != "" {
		fmt.Printf("X-CGI-Debug: Starting Up\r\n")
	}

	if len(os.Args) > 1 && os.Args[1] == "serve" {
		// Development mode
		// We can still use http.Handle for static in dev mode for efficiency/standard lib behavior
		fs := http.FileServer(http.Dir("static"))
		http.Handle("/static/", http.StripPrefix("/static/", fs))

		// For everything else, use our handler
		http.HandleFunc("/", handler)

		// We also need to explicitly register API paths if we use HandleFunc("/", handler)
		// because "/" matches everything not matched by others.
		// However, inside `handler`, we switch on path.
		// So `http.HandleFunc("/", handler)` is sufficient.

		log.Println("Server starting on :8080...")
		log.Fatal(http.ListenAndServe(":8080", nil))
		return
	}

	// CGI mode for production
	// Hostinger/Apache sometimes needs the Content-Type header immediately
	// if a panic occurs.
	defer func() {
		if r := recover(); r != nil {
			fmt.Printf("Content-Type: text/plain\r\n\r\n")
			fmt.Printf("CGI PANIC RECOVERY: %v\n", r)
		}
	}()

	if os.Getenv("GATEWAY_INTERFACE") != "" {
		if exe, err := os.Executable(); err == nil {
			dir := filepath.Dir(exe)
			os.Chdir(dir)

			// If we are in cgi-bin, the templates are one level up
			if filepath.Base(dir) == "cgi-bin" {
				os.Chdir("..")
			}
		}
	}

	err := cgi.Serve(http.HandlerFunc(handler))

	if err != nil {
		log.Fatal(err)
	}
}

func mainHandler(w http.ResponseWriter, r *http.Request) {
	tmpl, err := template.ParseFiles("templates/index.html")
	if err != nil {
		http.Error(w, "Template Error: "+err.Error()+"\nEnsure 'templates/index.html' exists relative to the binary.", http.StatusInternalServerError)
		return
	}
	tmpl.Execute(w, nil)
}
