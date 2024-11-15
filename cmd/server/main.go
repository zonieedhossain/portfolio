// cmd/server/main.go
package main

import (
	"encoding/json"
	"html/template"
	"log"
	"net/http"
	"os"
)

type Portfolio struct {
	Profile    Profile      `json:"profile"`
	Skills     []Skill      `json:"skills"`
	Projects   []Project    `json:"projects"`
	Experience []Experience `json:"experience"`
	Education  []Education  `json:"education"`
	Contact    Contact      `json:"contact"`
}

type Profile struct {
	Name        string `json:"name"`
	Title       string `json:"title"`
	Description string `json:"description"`
	Location    string `json:"location"`
	Avatar      string `json:"avatar"`
	Social      Social `json:"social"`
}

type Social struct {
	Github   string `json:"github"`
	LinkedIn string `json:"linkedin"`
	Twitter  string `json:"twitter"`
}

type Skill struct {
	Name     string `json:"name"`
	Category string `json:"category"`
	Level    int    `json:"level"`
	Icon     string `json:"icon"`
}

type Project struct {
	Title        string   `json:"title"`
	Description  string   `json:"description"`
	Image        string   `json:"image"`
	Technologies []string `json:"technologies"`
	LiveURL      string   `json:"liveUrl"`
	GithubURL    string   `json:"githubUrl"`
}

type Experience struct {
	Company      string   `json:"company"`
	Title        string   `json:"title"`
	Period       string   `json:"period"`
	Description  string   `json:"description"`
	Achievements []string `json:"achievements"`
}

type Education struct {
	Institution string `json:"institution"`
	Degree      string `json:"degree"`
	Period      string `json:"period"`
	GPA         string `json:"gpa"`
}

type Contact struct {
	Email    string `json:"email"`
	Phone    string `json:"phone"`
	Location string `json:"location"`
}

var portfolio Portfolio

func loadData() error {
	file, err := os.ReadFile("data/portfolio-1.json")
	if err != nil {
		return err
	}
	return json.Unmarshal(file, &portfolio)
}

func main() {
	// Load portfolio-1 data
	if err := loadData(); err != nil {
		log.Fatal("Failed to load portfolio-1 data:", err)
	}

	// Serve static files
	fs := http.FileServer(http.Dir("static"))
	http.Handle("/static/", http.StripPrefix("/static/", fs))

	// Main portfolio-1 page
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		tmpl := template.Must(template.ParseFiles("templates/index.html"))
		tmpl.Execute(w, portfolio)
	})

	// API endpoints
	http.HandleFunc("/api/profile", func(w http.ResponseWriter, r *http.Request) {
		json.NewEncoder(w).Encode(portfolio.Profile)
	})

	http.HandleFunc("/api/skills", func(w http.ResponseWriter, r *http.Request) {
		json.NewEncoder(w).Encode(portfolio.Skills)
	})

	http.HandleFunc("/api/projects", func(w http.ResponseWriter, r *http.Request) {
		json.NewEncoder(w).Encode(portfolio.Projects)
	})

	http.HandleFunc("/api/experience", func(w http.ResponseWriter, r *http.Request) {
		json.NewEncoder(w).Encode(portfolio.Experience)
	})

	// Start server
	log.Println("Server starting on :8080...")
	log.Fatal(http.ListenAndServe(":8080", nil))
}
