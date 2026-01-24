// Initial load
document.addEventListener('DOMContentLoaded', () => {
    updatePageTitle('Summary');

    // Set initial path bar
    document.getElementById('current-path').textContent = '/api/summary';

    // Show ready state
    showReadyState();

    // Start real-time clock
    updateClock();
    setInterval(updateClock, 1000);
});

// Menu item click handlers
document.querySelectorAll('.nav-item').forEach(button => {
    button.addEventListener('click', () => {
        // Update active state
        document.querySelectorAll('.nav-item').forEach(btn =>
            btn.classList.remove('active'));
        button.classList.add('active');

        // Update path and fetch content
        const path = button.dataset.path;
        const sectionTitle = button.dataset.title;

        document.getElementById('current-path').textContent = path;
        updatePageTitle(sectionTitle);

        // Don't fetch immediately - just show ready state for the new path
        showReadyState();
    });
});

// Send button click handler
document.querySelector('.send-btn').addEventListener('click', () => {
    const path = document.getElementById('current-path').textContent;
    fetchContent(path);
    fetchSystemStats(); // Update system stats on each request
});

// Window controls
document.querySelector('.window-button.close').onclick = () => {
    document.querySelector('.terminal').style.display = 'none';
};

document.querySelector('.window-button.minimize').onclick = () => {
    const content = document.querySelector('.terminal-content');
    content.style.display = content.style.display === 'none' ? 'block' : 'none';
};

document.querySelector('.window-button.maximize').onclick = () => {
    const terminal = document.querySelector('.terminal');
    if (terminal.style.height === '100vh') {
        terminal.style.height = 'calc(100vh - 4rem)'; // adjusted to fit within non-fullscreen
        terminal.style.position = 'relative';
        terminal.style.top = 'auto';
        terminal.style.left = 'auto';
        terminal.style.width = 'auto';
        terminal.style.zIndex = 'auto';
    } else {
        terminal.style.height = '100vh';
        terminal.style.position = 'fixed';
        terminal.style.top = '0';
        terminal.style.left = '0';
        terminal.style.width = '100%';
        terminal.style.zIndex = '1001';
    }
};

// Terminal drag functionality
let isDragging = false;
let currentX;
let currentY;
let initialX;
let initialY;
let xOffset = 0;
let yOffset = 0;

const terminal = document.querySelector('.terminal');
const terminalHeader = document.querySelector('.terminal-header');

terminalHeader.addEventListener('mousedown', dragStart);
document.addEventListener('mousemove', drag);
document.addEventListener('mouseup', dragEnd);

function dragStart(e) {
    if (e.target.classList.contains('window-button')) return;

    initialX = e.clientX - xOffset;
    initialY = e.clientY - yOffset;

    if (e.target === terminalHeader) {
        isDragging = true;
    }
}

function drag(e) {
    if (isDragging) {
        e.preventDefault();
        currentX = e.clientX - initialX;
        currentY = e.clientY - initialY;
        xOffset = currentX;
        yOffset = currentY;
        setTranslate(currentX, currentY, terminal);
    }
}

function dragEnd() {
    initialX = currentX;
    initialY = currentY;
    isDragging = false;
}

function setTranslate(xPos, yPos, el) {
    el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
}

// Page Title Helper
function updatePageTitle(sectionTitle) {
    if (sectionTitle) {
        document.title = `MD. ZONIEED HOSSAIN | ${sectionTitle} Portfolio`;
        const terminalTitle = document.querySelector('.terminal-title');
        if (terminalTitle) {
            terminalTitle.textContent = `~/portfolio/${sectionTitle.toLowerCase()}`;
        }
    }
}

// UI Helpers
function showLoading() {
    const content = document.getElementById('content');
    const statusDot = document.querySelector('.status-dot');

    content.innerHTML = `
        <div class="loading">
            <p class="loading-text">Executing request...</p>
        </div>
    `;
    if (statusDot) {
        statusDot.style.background = '#ffbd2e';
        statusDot.style.boxShadow = '0 0 12px #ffbd2e';
    }
    document.getElementById('status-text').textContent = 'Status: Processing';
}

function showReadyState() {
    const content = document.getElementById('content');
    const statusDot = document.querySelector('.status-dot');
    const path = document.getElementById('current-path').textContent;

    content.innerHTML = `
        <div class="ready-state">
            <div class="ready-icon">
                <i class="fas fa-terminal"></i>
            </div>
            <h2>Ready for Request</h2>
            <p>Target: <span class="path-highlight">${path}</span></p>
            <p class="hint-text">Click the "Send" button above to execute this request.</p>
        </div>
    `;

    if (statusDot) {
        statusDot.style.background = 'rgba(255, 255, 255, 0.2)';
        statusDot.style.boxShadow = 'none';
    }
    document.getElementById('status-text').textContent = 'Status: Idle';
    document.getElementById('response-time').textContent = 'Time: 0.00 ms';
}

// Fetch Logic
async function fetchContent(path) {
    const startTime = performance.now();
    const statusDot = document.querySelector('.status-dot');
    const content = document.getElementById('content');
    const statusText = document.getElementById('status-text');
    const timeText = document.getElementById('response-time');

    try {
        showLoading();

        // The user's code previously had some PHP path logic? We should stick to the direct path since it works with Go
        // const apiPath = `/api/${path.split('/').pop()}`; 
        // Go server handles /api/* directly.
        const apiPath = path;

        console.log(`[Fetch] Requesting: ${apiPath}`);
        const response = await fetch(apiPath);

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const data = await response.json();
        const endTime = performance.now();
        const responseTime = (endTime - startTime).toFixed(2);

        // Update content
        content.innerHTML = formatContent(data.data, path);

        // Update status
        if (statusText) statusText.textContent = `Status: ${data.status || 200}`;
        if (timeText) timeText.textContent = `Time: ${responseTime} ms`;
        if (statusDot) statusDot.style.background = '#27c93f';

    } catch (error) {
        console.error('Error:', error);
        content.innerHTML = `
            <div class="error-card modern-card">
                <div class="error-header">
                    <i class="fas fa-exclamation-triangle error-icon"></i>
                    <h3>API Connection Error</h3>
                </div>
                <p>Failed to load data from ${path}. Please check your connection or try again later.</p>
                <div class="error-details">${error.message}</div>
            </div>
        `;
        if (statusDot) {
            statusDot.style.background = '#ff5f56';
            statusDot.style.boxShadow = '0 0 12px #ff5f56';
        }
        if (statusText) statusText.textContent = 'Status: 500 Server Error';
    }
}

// Format content based on section
function formatContent(data, path) {
    switch (path) {
        case '/api/summary':
            const paragraphs = Array.isArray(data) ? data : [data];
            const summaryHTML = paragraphs.map((paragraph, index) => {
                return `<p class="hero-paragraph">${paragraph}</p>`;
            }).join('');

            return `
                <div class="summary-open">
                    ${summaryHTML}
                </div>
            `;

        case '/api/experience':
            return data.map((exp, index) => `
                <div class="experience-item-open">
                    <div class="open-header">
                        <div class="header-main">
                            <h3>${exp.title}</h3>
                            <span class="meta-tag font-mono">${exp.period}</span>
                        </div>
                        <h4>${exp.company}</h4>
                    </div>
                    <div class="open-body">
                        <p class="hero-paragraph">${exp.description}</p>
                        ${exp.achievements ? `
                            <ul class="achievements">
                                ${exp.achievements.map(achievement =>
                `<li>${achievement}</li>`).join('')}
                            </ul>
                        ` : ''}
                        ${exp.skills ? `
                            <div class="tech-stack">
                                ${exp.skills.map(skill =>
                    `<span class="tech-tag">${skill}</span>`).join('')}
                            </div>
                        ` : ''}
                    </div>
                    ${index < data.length - 1 ? '<div class="technical-separator"></div>' : ''}
                </div>
            `).join('');

        case '/api/projects':
            return data.map((project, index) => `
                <div class="project-item-open">
                    <div class="open-header">
                        <div class="header-main">
                            <h3><i class="fas fa-rocket blueprint-icon"></i> ${project.title}</h3>
                        </div>
                        <div class="project-links">
                            ${project.url ? `
                                <a href="${project.url}" target="_blank" class="project-link" title="Live Demo">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            ` : ''}
                            ${project.github ? `
                                <a href="${project.github}" target="_blank" class="project-link" title="GitHub">
                                    <i class="fab fa-github"></i>
                                </a>
                            ` : ''}
                        </div>
                    </div>
                    <div class="open-body">
                        <p class="hero-paragraph">${project.description}</p>
                        <div class="tech-stack-premium">
                            ${project.technologies.map(tech =>
                `<span class="premium-tag">${tech}</span>`).join('')}
                        </div>
                    </div>
                    ${index < data.length - 1 ? '<div class="technical-separator"></div>' : ''}
                </div>
            `).join('');

        case '/api/skills':
            return `
                <div class="technical-skills-grid-open">
                    ${data.map(category => `
                        <div class="skill-category-open">
                            <h3 class="skill-category-title-open">${category.category}</h3>
                            <div class="tech-stack-premium">
                                ${category.items.map(skill =>
                `<span class="premium-tag">${skill}</span>`).join('')}
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;

        case '/api/education':
            if (!data.education) {
                return `<div class="error">Unexpected data format</div>`;
            }
            return `
                <div class="terminal-education-open">
                    <div class="education-item-open">
                        <div class="open-header">
                            <div class="header-main">
                                <h3>${data.education.degree} <span class="meta-tag font-mono">Degree</span></h3>
                            </div>
                            <h4>${data.education.institution}</h4>
                        </div>
                        <div class="edu-meta-row">
                            <span class="meta-item"><i class="fas fa-calendar-alt"></i> ${data.education.period}</span>
                            ${data.education.gpa ? `<span class="meta-item"><i class="fas fa-graduation-cap"></i> GPA: ${data.education.gpa}</span>` : ''}
                        </div>
                    </div>
                    <div class="technical-separator"></div>
                    ${data.certifications ? `
                        <div class="certification-item-open">
                            <div class="open-header">
                                <h3><i class="fas fa-certificate blueprint-icon"></i> Certifications</h3>
                            </div>
                            <ul class="achievements">
                                ${data.certifications.map(cert =>
                `<li>${cert}</li>`).join('')}
                            </ul>
                        </div>
                    ` : ''}
                </div>
            `;

        case '/api/publications':
            return data.map((pub, index) => `
                <div class="publication-item-open">
                    <div class="open-header">
                        <div class="header-main">
                            <h3><i class="fas fa-scroll blueprint-icon"></i> ${pub.title}</h3>
                        </div>
                        <div class="project-links">
                            ${pub.url ? `
                                <a href="${pub.url}" target="_blank" class="project-link" title="View Publication">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            ` : ''}
                        </div>
                    </div>
                    <div class="open-body">
                        <p class="hero-paragraph authors">${pub.authors.join(', ')}</p>
                        <p class="pub-meta">${pub.publisher} • <span class="pub-date">${pub.date}</span></p>
                    </div>
                    ${index < data.length - 1 ? '<div class="technical-separator"></div>' : ''}
                </div>
            `).join('');

        default:
            return '<p class="error">Section not found</p>';
    }
}

// Real-time Clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
        hour12: false,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    const dateString = now.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const timeElement = document.getElementById('current-time');
    const dateElement = document.getElementById('current-date');

    if (timeElement) timeElement.textContent = timeString;
    if (dateElement) dateElement.textContent = dateString;
}

// Fetch System Stats
async function fetchSystemStats() {
    try {
        const response = await fetch('/api/system-stats');
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const result = await response.json();
        const data = result.data;

        // Update CPU
        const cpuValue = Math.round(data.cpu.usage);
        const cpuElement = document.getElementById('cpu-value');
        const cpuFill = document.getElementById('cpu-fill');

        if (cpuElement) cpuElement.textContent = `${cpuValue}%`;
        if (cpuFill) {
            cpuFill.style.width = `${cpuValue}%`;
            updateStatColor(cpuFill, cpuValue);
        }

        // Update RAM
        const ramValue = Math.round(data.ram.usage);
        const ramElement = document.getElementById('ram-value');
        const ramFill = document.getElementById('ram-fill');

        if (ramElement) ramElement.textContent = `${ramValue}%`;
        if (ramFill) {
            ramFill.style.width = `${ramValue}%`;
            updateStatColor(ramFill, ramValue);
        }

        // Update Network Quality
        const networkQualityElement = document.getElementById('network-quality');
        const networkQualityTextElement = document.getElementById('network-quality-text');

        // Calculate network quality based on download speed
        const downloadSpeed = data.network.download;
        let quality, qualityText;

        if (downloadSpeed >= 1800) {
            quality = '5G';
            qualityText = 'Excellent Fiber-like Connection';
        } else if (downloadSpeed >= 1000) {
            quality = '4G+';
            qualityText = 'Very Good Connection';
        } else if (downloadSpeed >= 500) {
            quality = '4G';
            qualityText = 'Good Connection';
        } else if (downloadSpeed >= 100) {
            quality = '3G';
            qualityText = 'Fair Connection';
        } else {
            quality = '2G';
            qualityText = 'Poor Connection';
        }

        if (networkQualityElement) networkQualityElement.textContent = quality;
        if (networkQualityTextElement) networkQualityTextElement.textContent = qualityText;

        // Update location
        const locationElement = document.getElementById('location-text');
        if (locationElement && data.location) {
            locationElement.textContent = data.location;
        }

        // Update Last Sync timestamp
        const lastFetchElement = document.getElementById('last-fetch');
        if (lastFetchElement) {
            const fetchTime = new Date().toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            lastFetchElement.textContent = `Last sync: ${fetchTime}`;
        }

    } catch (error) {
        console.error('Error fetching system stats:', error);
    }
}

// Helper: Update stat bar color based on usage
function updateStatColor(element, value) {
    element.classList.remove('warning', 'danger');

    if (value >= 80) {
        element.classList.add('danger');
    } else if (value >= 60) {
        element.classList.add('warning');
    }
}

// Helper: Format network speed
function formatNetworkSpeed(speed) {
    if (speed >= 1000) {
        return `${(speed / 1000).toFixed(1)} MB/s`;
    }
    return `${Math.round(speed)} KB/s`;
}
