<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Data structures synced from resume.md
$summary = [
    "👋 I’m Zonieed — a Senior Backend Engineer & Architect dedicated to solving complex data consistency and microservice orchestration challenges.",
    "Driven by an SRE mindset, I engineer systems where reliability isn't just a metric—it's the baseline. My focus is on absolute state correctness, high availability, and deterministic performance under high-concurrency (50k+ users).",
    "For 7+ years, I have navigated the landscapes of ERP, Logistics, and EdTech, transforming messy operational bottlenecks into clean, event-driven distributed ecosystems.",
    "I believe that true engineering seniority starts with a 'Reliability-First' mindset. I spend my time mentoring developers, reviewing architectures for distributed pitfalls, and designing for the long-term longevity of the product.",
    "📍 Based in Dhaka, Bangladesh — A global tech explorer bridging the gap between machines and mountains."
];

$experience = [
    [
        "company" => "Gononet Online Solutions Limited",
        "title" => "Senior Software Engineer | Team Lead",
        "period" => "August 2024 - Present",
        "description" => "Leading the architectural evolution of enterprise ERP and large-scale grocery logistics platforms.",
        "achievements" => [
            "Architected a 9-microservice ERP ecosystem (GonoERP) using Golang and gRPC, implementing domain isolation for Inventory, Sales and Identity.",
            "Engineered a high-precision Stock Engine using bin-level warehouse logic, ensuring atomic inventory consistency across multi-tenant clients.",
            "Implemented a fault-tolerant event system using Kafka and the Inbox pattern, solving message duplication and ensuring exactly-once delivery.",
            "Established system observability by integrating Grafana and Loki, reducing MTTR through structured logging and trace-based debugging.",
            "Designed multi-tenant Auth models using RBAC and ABAC interceptors, securing gRPC communication across the platform."
        ],
        "skills" => ["Golang", "gRPC", "Kafka", "PostgreSQL", "Grafana", "Loki"]
    ],
    [
        "company" => "Shikho Technologies",
        "title" => "SDE-II Golang Engineer | Core Infrastructure",
        "period" => "December 2021 - July 2024",
        "description" => "Architected mission-critical backend systems for Bangladesh's leading EdTech platform.",
        "achievements" => [
            "Optimized Live-Exam concurrency orchestration handling 50,000+ simultaneous participants using NATS Jetstream for low-latency state sync.",
            "Migrated the Bohubrihi (Professional Learning) monolith to a Golang microservices suite, increasing uptime from 95% to 99.9%.",
            "Developed asynchronous data pipelines using Kafka and MongoDB to synchronize engagement data across distributed analytics engines.",
            "Standardized K8s deployments by creating modular Helm charts and GitLab CI/CD pipelines for 15+ backend services."
        ],
        "skills" => ["Golang", "NATS Jetstream", "Kafka", "MongoDB", "Helm", "Kubernetes"]
    ],
    [
        "company" => "Code Concept Consulting (JL Audio / Garmin)",
        "title" => "Software Consultant (International)",
        "period" => "February 2022 - May 2024",
        "description" => "Engineered robust enterprise integration middleware for global electronics and hardware brands.",
        "achievements" => [
            "Developed Shopify-Dynamics 365 middleware in Go/Python, managing webhooks, delta synchronization and automated retry mechanisms.",
            "Implemented IaC modules using Terraform for AWS VPC, RDS and SFTP-bridge networking.",
            "Optimized performance for batch data handling across global WMS systems."
        ],
        "skills" => ["Golang", "Python", "Terraform", "AWS", "Dynamics 365", "Distributed Integration"]
    ],
    [
        "company" => "Ghuri Express Limited",
        "title" => "Senior Software Engineer | Team Lead",
        "period" => "June 2021 - December 2021",
        "description" => "Architected logistics and quick-commerce fulfillment platform.",
        "achievements" => [
            "Architected a zone-aware dispatching engine for logistics, utilizing custom geo-indexing and real-time rider tracking with Redis Pub/Sub.",
            "Led the end-to-end delivery of a 5-microservice logistics suite, managing the full lifecycle from merchant onboarding to rider operations."
        ],
        "skills" => ["Golang", "Redis Clusters", "Geo-indexing", "WebSockets", "Prometheus"]
    ]
];

$projects = [
    [
        "title" => "GonoERP (RetailerBook)",
        "description" => "Enterprise ERP platform for procurement, sales, inventory management and demand planning. Architecture focuses on high-precision stock engines and gRPC-driven domain isolation.",
        "technologies" => ["Golang", "PostgreSQL", "gRPC", "Kafka", "Docker", "Kubernetes"]
    ],
    [
        "title" => "gocraft (Open Source)",
        "description" => "Developed a modular CLI tool for scaffolding Go backend projects (Fiber/Echo/Gin) with standardized boilerplate, ORM setup (Bun/GORM/Sqlc) and Docker integration.",
        "technologies" => ["Golang", "CLI", "Boilerplate", "Docker"]
    ],
    [
        "title" => "Live-Exam Orchestrator",
        "description" => "High-concurrency orchestration engine handling 50k+ users. Uses NATS Jetstream for ultra-low latency state transition and event synchronization.",
        "technologies" => ["Golang", "NATS Jetstream", "Kafka", "Microservices"]
    ],
    [
        "title" => "Shopify ↔ Dynamics 365 Middleware",
        "description" => "Enterprise-grade integration engine for global hardware brands. Handles millions of sync cycles with strict transactional integrity and retry logic.",
        "technologies" => ["Golang", "AWS", "Terraform", "Exactly-Once Processing"]
    ]
];

$skills = [
    [
        "category" => "Programming & Ops",
        "items" => ["Golang (Go)", "Python", "Kubernetes", "Docker", "Helm", "Terraform", "CI/CD", "AWS", "GCP"]
    ],
    [
        "category" => "Distributed Systems",
        "items" => ["Apache Kafka", "NATS Jetstream", "gRPC / Protobuf", "Domain-Driven Design (DDD)", "Event-Driven Architecture", "Exactly-Once Processing"]
    ],
    [
        "category" => "Databases & Observability",
        "items" => ["PostgreSQL", "MongoDB", "Redis", "Grafana", "Loki", "Prometheus", "OpenTelemetry"]
    ],
    [
        "category" => "Engineering Philosophy",
        "items" => ["Correctness Over Cleverness", "SRE Mindset", "Idempotent API Design", "Legacy Monolith Migration"]
    ]
];

$publications = [
    [
        "title" => "Character and Mesh Optimization of Modern 3D Video Games",
        "publisher" => "Springer Singapore - IC DIS",
        "date" => "2020",
        "url" => "https://link.springer.com/chapter/10.1007/978-981-15-0694-9_60",
        "authors" => ["Md. Zonieed Hossain", "Ragib Hasan", "M. F. Mridha"]
    ]
];

$logs = [
    [
        "title" => "How to set up Apache Kafka with Docker",
        "summary" => "A beginner-friendly guide to bridging the gap between theory and production-ready event streaming setups using Docker containers.",
        "date" => "2024",
        "platform" => "Medium",
        "url" => "https://medium.com/@zonieed.uap/how-to-set-up-apache-kafka-with-docker-a-beginner-friendly-guide-95b0b8b649d2"
    ],
    [
        "title" => "Unique Interview Experience: Learning & Growth",
        "summary" => "Reflecting on a recent technical interview journey and the critical role of continuous learning in the Golang ecosystem.",
        "date" => "May 2024",
        "platform" => "LinkedIn",
        "url" => "https://www.linkedin.com/posts/zonieedhossain_interviewexperience-learningjourney-golang-activity-7361860680162951168-rnSG"
    ],
    [
        "title" => "ChatGPT's math mistake: why AI needs oversight",
        "summary" => "An engineering analysis of AI limitations in deterministic systems and why human oversight remains non-negotiable in backend architecture.",
        "date" => "August 2024",
        "platform" => "LinkedIn",
        "url" => "https://www.linkedin.com/posts/zonieedhossain_chatgpt-ai-engineering-activity-7358035402470907904-cv7M"
    ]
];

$education = [
    "education" => [
        "degree" => "B.Sc. in Computer Science & Engineering",
        "institution" => "University of Asia Pacific",
        "period" => "2015 - 2018"
    ],
    "certifications" => [
        "ACM-ICPC Asia Dhaka Regional Contest (2016)"
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

// Normalize path
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH);
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
    case '/logs':
    case '/api/logs':
        sendResponse($logs);
    case '/system-stats':
    case '/api/system-stats':
        $stats = [
            "time" => date("H:i:s"),
            "date" => date("l, F j, Y"),
            "location" => "Dhaka Node, Bangladesh",
            "cpu" => ["usage" => mt_rand(5, 12)],
            "ram" => ["usage" => mt_rand(15, 25)],
            "network" => ["download" => mt_rand(1200, 2400), "upload" => mt_rand(800, 1500)]
        ];
        sendResponse($stats);
    default:
        if ($path == '/' || $path == '') {
             sendResponse(["message" => "API is running"]);
        }
        http_response_code(404);
        echo json_encode(["status" => 404, "message" => "Not Found", "uri" => $uri, "path" => $path]);
        break;
}
?>
