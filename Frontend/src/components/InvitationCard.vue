<template>
    <div v-for="invitation in invitations" :key="invitation.id" class="invitationCard">
      <div class="cardImage">
        <img :src="invitation.event.image_link || '../assets/Images/Event.png'" alt="Event Image"/>
      </div>
      <div class="cardContent">
        <div class="cardDate">
          <h2>{{ getMonth(invitation.event.start_datetime) }}</h2>
          <h1>{{ getDays(invitation.event.start_datetime, invitation.event.end_datetime) }}</h1>
        </div>
        <div class="cardDetails">
          <h3>{{ invitation.event.title }}</h3>
          <p class="address">{{ invitation.event.location }}</p>
          <p class="time">{{ getTime(invitation.event.start_datetime, invitation.event.end_datetime) }}</p>
          <p>
            <span class="price"><img src="../assets/Icons/ticketCard.png" alt="ticket"/>{{ getPrice(invitation.event.tickets) }}</span>
            <span class="interested"><img src="../assets/Icons/starCard.png" alt="Interest"/>48 interested</span>
          </p>
        </div>
        <div class="cardActions">
          <button class="acceptButton" @click="respondInvitation(invitation.id, 'accepted')">Accept</button>
          <button class="rejectButton" @click="respondInvitation(invitation.id, 'rejected')">Reject</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import apiClient from '@/services/api';
  
  export default {
    name: 'InvitationCard',
    props: {
      userId: {
        type: Number,
        required: true
      }
    },
    data() {
      return {
        invitations: []
      };
    },
    mounted() {
      this.fetchInvitations();
    },
    methods: {
      async fetchInvitations() {
        try {
          const response = await apiClient.get(`/api/users/${this.userId}/invitations`);
          const invitations = response.data;
          const invitationsWithEvents = await Promise.all(invitations.map(async invitation => {
            const eventResponse = await apiClient.get(`/api/events/${invitation.event_id}`);
            return {
              ...invitation,
              event: eventResponse.data
            };
          }));
          this.invitations = invitationsWithEvents;
        } catch (error) {
          console.error('Error fetching invitations:', error);
        }
      },
      respondInvitation(invitationId, status) {
        apiClient.put(`/api/invitations/${invitationId}/respond`, { status })
          .then(() => {
            this.invitations = this.invitations.filter(invitation => invitation.id !== invitationId);
          })
          .catch(error => {
            console.error('Error responding to invitation:', error);
          });
      },
      getMonth(datetime) {
        const date = new Date(datetime);
        return date.toLocaleString('default', { month: 'short' }).toUpperCase();
      },
      getDays(start, end) {
        const startDate = new Date(start);
        const endDate = new Date(end);
        if (startDate.getDate() === endDate.getDate()) {
          return startDate.getDate();
        }
        return `${startDate.getDate()} - ${endDate.getDate()}`;
      },
      getTime(start, end) {
        const startTime = new Date(start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const endTime = new Date(end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        return `${startTime} - ${endTime}`;
      },
      getPrice(tickets) {
        if (tickets.length === 0) {
          return 'Free';
        }
        return `RM ${Math.min(...tickets.map(ticket => ticket.ticket_price))}`;
      }
    }
  }
  </script>
  
  <style>
  .invitationCard {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    margin: 20px;
    background-color: #fff;
    width: 60%;
    max-width: 800px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 30px;
    gap: 10px;
  }
  
  .cardDetails .price {
    color: #5A5A5A;
    font-weight: 500;
    margin-right: 10px;
  }
  
  .cardDetails img {
    width: 20px;
    height: 20px;
    margin-right: 5px;
    position: relative;
    top: 3px;
  }
  
  .cardDetails .interested {
    color: #5A5A5A;
    font-weight: 500;
  }
  
  .cardImage img {
    width: 100px;
    height: 100px;
    border-right: 1px solid #ddd;
    border-radius: 10px;
  }
  
  .cardContent {
    display: flex;
    flex-direction: row;
    padding: 10px;
    flex: 1;
  }
  
  .cardDate {
    text-align: center;
    margin-right: 15px;
  }
  
  .cardDate h2 {
    font-size: 20px;
    color: #6A5ACD;
    margin: 0;
  }
  
  .cardDate h1 {
    font-size: 27px;
    color: #333;
    margin: 0;
  }
  
  .cardDetails {
    flex: 1;
  }
  
  .cardDetails h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
  }
  
  .cardDetails .address,
  .cardDetails .time,
  .cardDetails .price,
  .cardDetails .interested {
    font-size: 14px;
    color: #555;
  }
  
  .cardDetails .price {
    display: inline-block;
    margin-right: 10px;
  }
  
  .cardDetails .interested {
    display: inline-block;
  }
  
  .cardActions {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-left: 15px;
  }
  
  .acceptButton, .rejectButton {
    padding: 5px 10px;
    margin-top: 5px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 80px;
  }
  
  .acceptButton {
    background-color: #007bff;
    color: #fff;
  }
  
  .rejectButton {
    background-color: #ccc;
  }
  </style>
  