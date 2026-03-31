<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Data structures extracted from main.go
$summary = [
    "👋 Hi, I’m Zonieed. I am a Senior Software Engineer with a deep passion for Golang and microservices architecture.",
    "Throughout my career, I have been dedicated to building scalable, efficient and robust solutions. My approach is rooted in a Site Reliability Engineering (SRE) mindset—prioritizing low-latency communication, specific performance optimizations and high availability to ensure systems perform seamlessly at scale.",
    "With over 7 years of experience across ERP, logistics and EdTech domains, I specialize in turning complex business problems into clean, reliable software. I’ve designed stock tracking engines, built fault-tolerant integrations, migrated legacy monoliths to microservices and led teams through production-grade system design.",
    "I care deeply about system clarity, correctness and long-term maintainability. Beyond just writing code, I enjoy mentoring engineers, reviewing designs and helping teams cultivate a culture of engineering excellence.",
    "📍 Based in Dhaka, Bangladesh — open to global opportunities."
];

$experience = [
    [
        "company" => "Gononet Online Solutions Limited",
        "title" => "Senior Software Engineer, Team Lead",
        "period" => "August 2024 - Present",
        "description" => "Leading backend development for enterprise ERP and grocery delivery platforms.",
        "achievements" => [
            "Designed and maintained core ERP services (user management, sales, purchase, inventory, authentication, API gateway)",
            "Built stock tracking engine with bin-level warehouse logic to improve inventory efficiency and lookup performance",
            "Implemented RBAC/ABAC security models for multi-tenant environments",
            "Developed vendor discovery and SLA-based routing logic for grocery delivery platform",
            "Automated vendor onboarding and zone allocation workflows",
            "Mentored junior engineers and conducted code/design reviews"
        ],
        "skills" => ["Golang", "PostgreSQL", "gRPC", "Kafka", "Docker", "Kubernetes"]
    ],
    [
        "company" => "Shikho Technologies Bangladesh Limited",
        "title" => "SDE-II Golang Engineer, Core Infrastructure",
        "period" => "December 2021 - July 2024",
        "description" => "Built core backend infrastructure for Bangladesh's leading EdTech platform.",
        "achievements" => [
            "Developed exam orchestration and live-exam systems handling concurrent user loads",
            "Created data pipelines synchronizing learning, reporting and KPI systems",
            "Enhanced course management, enrollment and affiliate modules",
            "Implemented asynchronous workflows using message queues for reliable event processing",
            "Migrated Bohubrihi (professional learning platform) from WordPress monolith to Golang microservices",
            "Built features for gateway, certification and analytics services",
            "Automated data synchronization and certificate issuance workflows"
        ],
        "skills" => ["Golang", "PostgreSQL", "MongoDB", "Kafka", "gRPC", "Docker", "Microservices"]
    ],
    [
        "company" => "Code Concept Consulting (JL Audio / Garmin)",
        "title" => "Software Consultant (Contractual, Part-Time)",
        "period" => "February 2022 - May 2024",
        "description" => "Backend consulting for international clients including JL Audio and Garmin.",
        "achievements" => [
            "Built middleware in Go and Python integrating Shopify with Microsoft Dynamics 365",
            "Designed fault-tolerant API integrations with retry logic, logging and idempotent operations",
            "Implemented delta updates and webhook listeners for real-time synchronization",
            "Developed WMS features for Shopify and optimized batch data handling",
            "Created Python/Django admin dashboard for integration monitoring",
            "Deployed infrastructure using Terraform on cloud platforms"
        ],
        "skills" => ["Golang", "Python", "Django", "PostgreSQL", "Terraform", "AWS"]
    ],
    [
        "company" => "Ghuri Express Limited",
        "title" => "Senior Software Engineer, Team Lead",
        "period" => "June 2021 - December 2021",
        "description" => "Led backend development for logistics and quick-commerce delivery platform.",
        "achievements" => [
            "Designed zone-aware dispatch logic with geo-indexing and SLA-based routing",
            "Implemented real-time rider tracking using Redis pub/sub and WebSockets",
            "Built merchant onboarding workflows and control panel APIs",
            "Optimized PostgreSQL queries and implemented caching strategies with Redis",
            "Added monitoring and observability with Prometheus and Grafana"
        ],
        "skills" => ["Golang", "PostgreSQL", "Redis", "WebSockets", "Docker", "Kubernetes"]
    ],
    [
        "company" => "Ghuri Express Limited",
        "title" => "Software Engineer (Backend)",
        "period" => "February 2021 - May 2021",
        "description" => "Designed and launched parcel delivery system with microservices architecture.",
        "achievements" => [
            "Built 5-microservice delivery system from scratch",
            "Automated deployment pipelines using Docker and Kubernetes",
            "Launched complete delivery platform 3 months ahead of schedule"
        ],
        "skills" => ["Golang", "PostgreSQL", "Redis", "Docker", "Kubernetes"]
    ],
    [
        "company" => "Adeffi (formerly Sticker Driver Limited)",
        "title" => "Software Developer (Backend)",
        "period" => "June 2019 - February 2021",
        "description" => "Built backend services for vehicle advertising and campaign management platform.",
        "achievements" => [
            "Developed Golang microservices for campaign lifecycle, billing, driver tracking and reporting",
            "Integrated mapping APIs with optimized distance calculations and static map rendering",
            "Improved API response times through caching and query optimization",
            "Deployed services on Kubernetes and Google Cloud Platform",
            "Built campaign data pipelines and contributed to CI/CD workflows"
        ],
        "skills" => ["Golang", "PostgreSQL", "Redis", "Docker", "GCP", "Kubernetes"]
    ],
    [
        "company" => "Avalon Hosting Services Limited",
        "title" => "Intern Front-End Web Developer",
        "period" => "January 2019 - May 2019",
        "description" => "Frontend development internship at USA-based hosting provider.",
        "achievements" => [
            "Improved responsive layouts and fixed cross-browser compatibility issues",
            "Enhanced template modularity using HTML, CSS and JavaScript",
            "Collaborated with senior developers on UI improvements and documentation"
        ],
        "skills" => ["HTML", "CSS", "JavaScript"]
    ]
];

$projects = [
    [
        "title" => "GonoERP (RetailerBook)",
        "description" => "Enterprise ERP platform for procurement, sales, inventory management and demand planning. Built with microservices architecture featuring user management, authentication, sales, purchase and inventory modules with advanced stock tracking using warehouse bin logic.",
        "technologies" => ["Golang", "PostgreSQL", "gRPC", "Kafka", "Docker", "Kubernetes"]
    ],
    [
        "title" => "JL Audio / Garmin Middleware",
        "description" => "Integration platform synchronizing Shopify orders and inventory with Microsoft Dynamics 365. Features fault-tolerant APIs with retry logic, webhook listeners, delta updates and real-time data synchronization for enterprise e-commerce operations.",
        "url" => "https://www.jlaudio.com/",
        "technologies" => ["Golang", "Python", "Django", "PostgreSQL", "Terraform", "AWS"]
    ],
    [
        "title" => "Shikho EdTech Platform",
        "description" => "National curriculum EdTech platform with exam orchestration, live exams, data pipelines, course management and large-scale learner engagement. Handles concurrent users with event-driven architecture and real-time analytics.",
        "technologies" => ["Golang", "PostgreSQL", "MongoDB", "Kafka", "gRPC", "Microservices"]
    ],
    [
        "title" => "Bohubrihi Learning Platform",
        "description" => "Professional learning platform migrated from WordPress monolith to Golang microservices. Features course management, enrollment systems, certification workflows and analytics for scalable content delivery.",
        "url" => "https://www.bohubrihi.com/",
        "technologies" => ["Golang", "PostgreSQL", "Microservices", "Docker", "Kubernetes"]
    ],
    [
        "title" => "Ghuri Express Logistics",
        "description" => "Real-time logistics and quick-commerce platform with zone-aware dispatching, SLA-based routing, rider tracking using WebSockets, merchant onboarding and control panel for operations management.",
        "technologies" => ["Golang", "PostgreSQL", "Redis", "WebSockets", "Docker", "Kubernetes"]
    ],
    [
        "title" => "GorillaMove Grocery Delivery",
        "description" => "Grocery delivery backend with vendor discovery, automated zone allocation, SLA-based routing and vendor onboarding workflows. Optimized for fast fulfillment and operational efficiency.",
        "technologies" => ["Golang", "PostgreSQL", "gRPC", "Kafka", "Docker"]
    ],
    [
        "title" => "Sticker Driver / CarAds",
        "description" => "Vehicle advertising platform with geo-targeted campaign management, driver tracking, billing systems and optimized mapping integrations. Features distance-based campaign logic and static map rendering for cost efficiency.",
        "url" => "https://www.carads.com.bd/",
        "technologies" => ["Golang", "PostgreSQL", "Redis", "Docker", "GCP"]
    ]
];

$skills = [
    [
        "category" => "Programming Languages",
        "items" => ["Golang (Go)", "Python"]
    ],
    [
        "category" => "Frameworks & Libraries",
        "items" => ["Gin", "Fiber", "Echo", "Django", "GORM"]
    ],
    [
        "category" => "Databases & Caching",
        "items" => ["PostgreSQL", "MongoDB", "MySQL", "ArangoDB", "Redis"]
    ],
    [
        "category" => "Messaging & Streaming",
        "items" => ["Apache Kafka", "NATS", "RabbitMQ"]
    ],
    [
        "category" => "APIs & Communication",
        "items" => ["gRPC", "REST", "GraphQL"]
    ],
    [
        "category" => "Cloud & DevOps",
        "items" => ["Docker", "Kubernetes", "AWS", "GCP", "Terraform", "Linux"]
    ],
    [
        "category" => "Architecture & System Design",
        "items" => [
            "Microservices Architecture",
            "Event-Driven Architecture",
            "Domain-Driven Design (DDD)"
        ]
    ],
    [
        "category" => "Observability & Tooling",
        "items" => ["Git", "Prometheus", "Grafana"]
    ]
];

$education = [
    "education" => [
        "degree" => "Bachelor of Science in Computer Science and Engineering",
        "institution" => "University of Asia Pacific",
        "period" => "2015 - 2018",
        "gpa" => ""
    ],
    "certifications" => [
        "The 2016 ACM-ICPC Asia Dhaka Regional Contest - University of Asia Pacific",
        "The 2016 ACM-ICPC Bangladesh National Collegiate Programming Contest - University of Asia Pacific"
    ]
];

$publications = [
    [
        "title" => "Character and Mesh Optimization of Modern 3D Video Games",
        "publisher" => "Springer Singapore - 2nd International Conference on Data & Information Sciences",
        "date" => "January 2020",
        "url" => "https://link.springer.com/chapter/10.1007/978-981-15-0694-9_60",
        "authors" => [
            "Md. Zonieed Hossain", "Ragib Hasan", "Sumittra Chakraborti",
            "Taukir Ahamed", "Md. Abdul Hamid", "M. F. Mridha"
        ]
    ]
];

// Helper to handle response
function sendResponse($data) {
    echo json_encode([
        "status" => 200,
        "time" => microtime(true) * 1000,
        "data" => $data
    ]);
    exit;
}

// Get path from URL
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH);

// Normalize path: strip /api/ or /api.php/ or /index.php/ if present
$path = preg_replace('/^\/(api\.php|index\.php|api)/', '', $path);

switch ($path) {
    case '/summary':
    case '/api/summary':
        sendResponse($summary);
    case '/experience':
    case '/api/experience':
        sendResponse($experience);
    case '/projects':
    case '/api/projects':
        sendResponse($projects);
    case '/skills':
    case '/api/skills':
        sendResponse($skills);
    case '/education':
    case '/api/education':
        sendResponse($education);
    case '/publications':
    case '/api/publications':
        sendResponse($publications);
    case '/system-stats':
    case '/api/system-stats':
        $stats = [
            "time" => date("H:i:s"),
            "date" => date("l, F j, Y"),
            "location" => "Dhaka, Bangladesh",
            "cpu" => [
                "usage" => 15 + (mt_rand(0, 450) / 10),
                "cores" => 8
            ],
            "ram" => [
                "used" => 4096 + (mt_rand(0, 20480) / 10),
                "total" => 16384,
                "usage" => 25 + (mt_rand(0, 350) / 10)
            ],
            "network" => [
                "upload" => mt_rand(0, 500),
                "download" => mt_rand(0, 2000)
            ]
        ];
        sendResponse($stats);
    default:
        // Fallback for root or unknown paths
        if ($path == '/' || $path == '') {
             sendResponse(["message" => "API is running"]);
        }
        http_response_code(404);
        echo json_encode(["status" => 404, "message" => "Not Found", "uri" => $uri, "path" => $path]);
        break;
}
