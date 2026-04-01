<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Data structures synced from resume.md
$summary = [
    "👋 I’m Zonieed — a Senior Backend Engineer (Go) & Distributed Systems Lead based in Dhaka, Bangladesh.",
    "Senior Backend Engineer with 7+ years building Go-based distributed systems and event-driven microservices across ERP, EdTech and logistics domains. Specialized in consistency-critical systems: inventory correctness, idempotent event processing and multi-tenant isolation.",
    "Proven in designing high-concurrency systems, leading microservices migrations and delivering production-grade backend infrastructure.",
    "Contributed to backend infrastructure at Shikho (Forbes Asia 100, 2.5M+ users) and delivered mission-critical EDI integrations for JL Audio, subsequently acquired by Garmin (NYSE: GRMN).",
    "📍 Open to Local, Remote & Relocation."
];

$experience = [
    [
        "company" => "Gononet Online Solutions Limited",
        "url" => "https://gononet.net",
        "title" => "Senior Software Engineer (Backend) & Team Lead",
        "period" => "Aug 2024 -- Present",
        "description" => "RetailerBook --- multi-tenant ERP for retail inventory and procurement • GorillaMove --- instant grocery delivery platform, 20K+ customers, Dhaka",
        "achievements" => [
            "Eliminated cross-service data drift in a multi-tenant retail system by decomposing a monolithic ERP into isolated microservices across inventory, sales, auth and purchase.",
            "Prevented overselling under concurrent order processing by engineering a high-concurrency inventory engine using Go and PostgreSQL (bun.Tx) with SELECT FOR UPDATE row-level locking.",
            "Eliminated per-handler auth boilerplate across all service contracts by architecting a reflection-based gRPC interceptor enforcing tenant-scoped ABAC attribute validation.",
            "Guaranteed exactly-once delivery of stock and order updates by implementing a Kafka Inbox pattern, wrapping consumer ingestion logic within atomic database transactions.",
            "Improved real-time on-hand stock calculations across bin locations by implementing CTE-based dynamic stock valuation queries in PostgreSQL.",
            "Solved nearest-store discovery for GorillaMove by implementing Meilisearch geo-indexing with a secondary verification pass using map APIs.",
            "Improved system debuggability under live load by establishing Grafana and Loki structured logging with trace correlation across distributed services.",
            "Standardized gRPC-first service templates and Clean Architecture patterns across backend teams, reducing architectural drift.",
            "Led and mentored a backend team of 4 engineers, conducting design reviews, code reviews and technical mentoring."
        ],
        "skills" => ["Go (Golang)", "PostgreSQL", "Kafka", "gRPC", "Meilisearch", "Meilisearch Geo-indexing", "Grafana", "Loki"]
    ],
    [
        "company" => "Shikho Technologies Limited",
        "url" => "https://shikho.com",
        "title" => "SDE-II Golang Engineer",
        "period" => "Dec 2021 -- Jul 2024",
        "description" => "Bangladesh's leading EdTech --- Forbes Asia 100 (2022) • VC-backed ($8.5M) • Platform grew from 500K to 2.5M+ registered users during tenure. Supported Bohubrihi (acquired by Shikho).",
        "achievements" => [
            "Decoupled real-time student submissions from intensive reporting pipelines by scaling live-exam orchestration using NATS JetStream during national exam periods.",
            "Prevented exam collusion at national scale by designing a deterministic exam randomizer service using session and exam IDs as entropy seeds.",
            "Eliminated content duplication across academic programs by architecting a many-to-many lesson-mapping layer, reducing data storage overhead.",
            "Ensured non-blocking user experiences during heavy processing tasks by implementing RabbitMQ-based asynchronous workers for video ingestion and processing.",
            "Migrated core backend components of the Bohubrihi WordPress monolith (100K+ users) into isolated Go microservices using a Python-based EAV normalization pipeline.",
            "Ensured reliable analytics ingestion under high traffic by designing event-driven data pipelines for learner activity and reporting systems using NATS JetStream and MongoDB.",
            "Reduced query latency and database load under high-traffic conditions by optimizing PostgreSQL and MongoDB through index tuning and schema improvements."
        ],
        "skills" => ["Go (Golang)", "NATS JetStream", "RabbitMQ", "PostgreSQL", "MongoDB", "Python"]
    ],
    [
        "company" => "Code Concept Consulting",
        "url" => "https://codeconceptconsulting.com",
        "title" => "Software Consultant (Backend)",
        "period" => "Feb 2022 -- May 2024",
        "description" => "Client: JL Audio --- US-based premium audio manufacturer (600+ employees), subsequently acquired by Garmin (NYSE: GRMN) in September 2023.",
        "achievements" => [
            "Ensured cross-system data consistency for a US client subsequently acquired by Garmin by designing fault-tolerant Shopify–Microsoft Dynamics 365 synchronization middleware in Go and Python.",
            "Eliminated race conditions and duplicate updates across synchronization pipelines by implementing retry-safe, idempotent integration workflows with transactional guards.",
            "Enabled reliable global fulfillment data exchange by engineering XML-based SFTP pipelines in ASN 856 format for 3PL partners including Expeditors.",
            "Eliminated hard-coded EDI mapping brittleness by refactoring the BRP part-number mapping system into a dynamic S3-based service.",
            "Enabled accurate time-bound financial processing for global retail operations by engineering a fiscal calendar module synchronizing non-standard trade periods from Oracle ERP data."
        ],
        "skills" => ["Go (Golang)", "Python", "Shopify API", "Microsoft Dynamics 365", "SFTP", "ASN 856 EDI", "S3"]
    ],
    [
        "company" => "Ghuri Express Limited",
        "title" => "Senior Backend Engineer & Team Lead",
        "period" => "Feb 2021 -- Dec 2021",
        "description" => "Logistics and quick-commerce delivery platform.",
        "achievements" => [
            "Enabled real-time parcel visibility by leading development of a logistics platform utilizing Redis for low-latency rider location tracking and PostgreSQL for parcel lifecycle audits.",
            "Improved deployment reliability and release consistency by standardizing GitLab CI/CD pipelines, Helm charts and Kubernetes deployments across services."
        ],
        "skills" => ["Go (Golang)", "Redis", "PostgreSQL", "GitLab CI/CD", "Helm", "Kubernetes"]
    ],
    [
        "company" => "Sticker Driver (now Adeffi)",
        "url" => "https://adeffi.com",
        "title" => "Backend Engineer",
        "period" => "Jun 2019 -- Feb 2021",
        "description" => "Outdoor advertising and vehicle tracking platform.",
        "achievements" => [
            "Enabled accurate advertising impact reporting by building GPS telemetry pipelines using path-simplification logic and distance computation on 5-second telemetry intervals.",
            "Eliminated database overload under high-frequency GPS ingestion by migrating hot-path state storage from PostgreSQL to Redis."
        ],
        "skills" => ["Go (Golang)", "PostgreSQL", "Redis", "GPS Telemetry", "Path Simplification"]
    ]
];

$projects = [
    [
        "title" => "gocraft",
        "url" => "https://github.com/zonieedhossain/gocraft",
        "description" => "CLI tool to scaffold modular Go backend services with configurable framework selection, ORM setup (Bun/GORM/Sqlc), auth bootstrapping and Docker integration out of the box.",
        "technologies" => ["Go (Golang)", "CLI", "Shell", "Docker"]
    ],
    [
        "title" => "go-ott-api",
        "url" => "https://github.com/zonieedhossain/go-ott-api",
        "description" => "Modular Go backend for video platform workflows implementing JWT auth, rate limiting, PostgreSQL, Redis caching, Consul-based config management and Dockerized local development.",
        "technologies" => ["Go (Golang)", "PostgreSQL", "Redis", "Consul", "JWT"]
    ],
    [
        "title" => "Proto-Central",
        "description" => "Centralized gRPC schema registry at Gononet, eliminating contract drift and reducing integration errors across backend service teams.",
        "technologies" => ["Go (Golang)", "gRPC", "Protobuf", "Schema Registry"]
    ]
];

$skills = [
    [
        "category" => "Languages",
        "items" => ["Go (Golang)", "Python", "SQL"]
    ],
    [
        "category" => "Backend & Architecture",
        "items" => ["Microservices", "Distributed Systems", "Event-Driven Architecture", "Domain-Driven Design", "Clean Architecture"]
    ],
    [
        "category" => "APIs & Messaging",
        "items" => ["gRPC (Protobuf)", "REST", "Kafka (Inbox/Outbox)", "NATS JetStream", "RabbitMQ"]
    ],
    [
        "category" => "Databases & Observability",
        "items" => ["PostgreSQL", "Redis", "MongoDB", "MySQL", "Prometheus", "Grafana", "Loki"]
    ],
    [
        "category" => "Infrastructure",
        "items" => ["AWS", "Docker", "Kubernetes", "CI/CD", "Linux", "GCP (familiar)", "Helm", "Terraform"]
    ],
    [
        "category" => "Patterns & Security",
        "items" => ["Idempotency", "RBAC", "ABAC", "Multi-Tenant Architecture", "Inbox/Outbox"]
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
        "degree" => "B.Sc. in Computer Science and Engineering",
        "institution" => "University of Asia Pacific",
        "period" => "2015 -- 2018"
    ],
    "certifications" => [
        "ACM-ICPC Asia Dhaka Regional (2016)",
        "Bangladesh NCPC (2016)"
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
