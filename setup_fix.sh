#!/bin/bash

# Quick Setup Script for Smart Classroom Fix
echo "🔧 Setting up Smart Classroom with WebRTC fixes..."

# Make scripts executable
chmod +x start_servers.sh stop_servers.sh test_classroom.py

# Check Python virtual environment
if [ ! -d "classroom_env" ]; then
    echo "📦 Creating Python virtual environment..."
    python3 -m venv classroom_env
fi

# Activate and install dependencies
source classroom_env/bin/activate
pip install fastapi uvicorn websockets pydantic aiohttp requests python-multipart

echo "✅ Setup complete!"
echo ""
echo "🚀 Next steps:"
echo "1. Run: ./start_servers.sh"
echo "2. Test: python test_classroom.py"
echo "3. Use the system with teacher and student accounts"
echo ""
echo "📖 Read SMART_CLASSROOM_FIX.md for detailed information"
