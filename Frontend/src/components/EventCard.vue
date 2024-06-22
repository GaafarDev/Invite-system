<template>
    <div class="eventCard">
        <div class="upperCard">
            <div class="eventCardImage">
                <img src="../assets/Images/Event.png" alt="Event Image"/>
                <div class="eventType">{{ eventType }}</div>
                <div class="eventStar">
                    <img src="../assets/Icons/star_icon.png" alt="Star Icon"/>
                </div>
            </div>
        </div>
        
        <div class="bottomCard">
            <div class="eventDate">
                <h2>{{ eventMonth }}</h2>
                <h1>{{ eventDays }}</h1>
            </div>
            <div class="eventDetails">
                <ul>
                    <li><h3>{{ eventTitle }}</h3></li>
                    <li><p class="address">{{ eventLocation }}</p></li>
                    <li><p class="time">{{ eventTime }}</p></li>
                    <li>
                        <p>
                            <span class="price"><img src = "../assets/Icons/ticketCard.png" alt = "ticket"/>{{ eventPrice }}</span>
                            <span class="interested"><img src = "../assets/Icons/starCard.png" alt = "ticket"/>{{ eventInterested }} interested</span>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    export default {
        name: 'EventCard',
        props: {
            imageSrc: {
                type: String,
                default: "../assets/Images/Event.png"
            },
            eventType: {
                type: String,
                default: "Travel & Adventure"
            },
            eventMonth: {
                type: String,
                default: "NOV"
            },
            eventDays: {
                type: String,
                default: "25 - 26"
            },
            eventTitle: {
                type: String,
                default: "Lakeside Camping at Pawna"
            },
            eventLocation: {
                type: String,
                default: "Jalan Sultan Yahya Petra, UTMKL"
            },
            eventTime: {
                type: String,
                default: "8:30 AM - 7:30 PM"
            },
            eventPrice: {
                type: String,
                default: "RM 100"
            },
            eventInterested: {
                type: Number,
                default: 14
            }
        }
    }
    </script>
    
    <style>
    @import '../assets/css/EventCard.css';
    </style>
    