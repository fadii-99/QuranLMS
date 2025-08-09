#!/bin/bash

# Quran LMS - Start All Servers Script
# This script starts both Laravel and Python API servers

echo "🚀 Starting Quran LMS Complete System"
echo "======================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to check if port is in use
check_port() {
    local port=$1
    if lsof -Pi :$port -sTCP:LISTEN -t >/dev/null ; then
        return 0
    else
        return 1
    fi
}

# Check if Laravel is running on port 8000
if check_port 8000; then
    echo -e "${YELLOW}⚠️  Laravel appears to be running on port 8000${NC}"
    echo -e "${BLUE}ℹ️  You can access Laravel at: http://localhost:8000${NC}"
else
    echo -e "${RED}❌ Laravel is not running on port 8000${NC}"
    echo -e "${YELLOW}💡 Please start Laravel with: php artisan serve${NC}"
fi

# Check if Python API is running on port 8002
if check_port 8002; then
    echo -e "${YELLOW}⚠️  Python API appears to be running on port 8002${NC}"
    echo -e "${BLUE}ℹ️  You can access Python API docs at: http://localhost:8002/docs${NC}"
else
    echo -e "${GREEN}🐍 Starting Python Classroom API Server...${NC}"
    
    # Activate virtual environment and start Python API
    cd "$(dirname "$0")"
    
    if [ ! -d "classroom_env" ]; then
        echo -e "${YELLOW}📦 Creating virtual environment...${NC}"
        python3 -m venv classroom_env
        echo -e "${YELLOW}📚 Installing dependencies...${NC}"
        source classroom_env/bin/activate
        pip install fastapi uvicorn websockets pydantic aiohttp requests
    fi
    
    source classroom_env/bin/activate
    echo -e "${GREEN}✅ Python API Server starting on port 8002...${NC}"
    python classroom_api_server.py &
    PYTHON_PID=$!
    echo -e "${GREEN}✅ Python API Server started with PID: $PYTHON_PID${NC}"
fi

echo ""
echo -e "${GREEN}🎉 System Status:${NC}"
echo -e "${BLUE}📚 Laravel LMS: http://localhost:8000${NC}"
echo -e "${BLUE}🐍 Python API: http://localhost:8002${NC}"
echo -e "${BLUE}📊 API Docs: http://localhost:8002/docs${NC}"
echo -e "${BLUE}🔌 WebSocket: ws://localhost:8002/ws/{room_code}${NC}"
echo ""
echo -e "${YELLOW}💡 To stop servers:${NC}"
echo -e "${YELLOW}   - Laravel: Ctrl+C in Laravel terminal${NC}"
echo -e "${YELLOW}   - Python API: pkill -f classroom_api_server${NC}"
echo ""

# Keep script running if Python was started
if [ ! -z "$PYTHON_PID" ]; then
    echo -e "${GREEN}🔄 Python API is running. Press Ctrl+C to stop...${NC}"
    wait $PYTHON_PID
fi
