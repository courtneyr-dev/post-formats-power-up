# Chat Log Format Examples - Parser-Compatible

These examples are tested against the actual Chat Log parser and will work correctly.

## Understanding the Parser

The Chat Log parser supports several formats. Here are the **actual working patterns**:

### Format 1: Slack/Discord Export Style

**Pattern:** `Name  HH:MM AM/PM` (note: **2 spaces** between name and time)

```
sarah  9:30 AM
Hey team! 👋 Ready to kick off the new website project?

mike  9:31 AM
Absolutely! I've been reviewing the requirements doc.

sarah  9:32 AM
Great! Let's start with the tech stack discussion.
What are everyone's thoughts on using React vs Vue?

jessica  9:33 AM
I'm leaning towards React. Better ecosystem and
more developers on the team are familiar with it.

mike  9:34 AM
+1 for React. We also have those reusable components
from the last project.
```

---

### Format 2: Username-Then-Timestamp (Multi-line)

**Pattern:** Username on one line, timestamp on next, message after

```
sarah
9:30 AM
Hey team! 👋 Ready to kick off the new website project?

mike
9:31 AM
Absolutely! I've been reviewing the requirements doc.

sarah
9:32 AM
Great! Let's start with the tech stack discussion.
What are everyone's thoughts on using React vs Vue?
```

---

### Format 3: WhatsApp Export Format

**Pattern:** `[Date/Time] Name: Message`

```
[01/16/2024, 10:23:00] Mom: Good morning! 🌞 Has everyone thought about the lake house trip next weekend?

[01/16/2024, 10:25:00] Dad: I'm in! Should we leave Friday evening or Saturday morning?

[01/16/2024, 10:27:00] Jake: friday evening!! less traffic 🚗

[01/16/2024, 10:28:00] Emma: I vote Saturday morning. I have a work thing Friday night 😕

[01/16/2024, 10:30:00] Mom: Let's do Saturday morning then. 8 AM departure?
```

---

### Format 4: SRT Subtitle Format

**Pattern:** Subtitle numbering with timecodes

```
1
00:00:00,000 --> 00:00:03,500
Welcome to our productivity app tutorial!

2
00:00:03,500 --> 00:00:07,000
Today we'll show you how to get started in just 5 minutes.

3
00:00:07,500 --> 00:00:11,000
First, create your account by clicking the "Sign Up" button.

4
00:00:11,500 --> 00:00:15,000
Enter your email address and choose a secure password.
```

---

### Format 5: VTT Caption Format

**Pattern:** WEBVTT header with speaker tags

```
WEBVTT

00:00.000 --> 00:04.000
<v Speaker 1>Good morning everyone and welcome to WebDev Conference 2024.

00:04.500 --> 00:08.000
<v Speaker 1>Today I'm excited to talk about the future of web accessibility.

00:08.500 --> 00:12.000
<v Speaker 1>Let's start with some important statistics.

00:12.500 --> 00:16.000
<v Speaker 1>15% of the world's population has some form of disability.
```

---

### Format 6: Descript-Style Timecodes

**Pattern:** `Name (HH:MM:SS): Message`

```
Alice (00:00:01): Hello and welcome to today's podcast!

Bob (00:00:15): Thanks for having me! I'm excited to discuss web development trends.

Alice (00:00:30): Let's start with the biggest change this year - what would you say that is?

Bob (00:00:45): I'd say it's the rise of server components in React.
```

---

### Format 7: Bracket Timestamp Style

**Pattern:** `[HH:MM:SS] Name: Message`

```
[00:00:01] Alice: Hello and welcome to today's podcast!

[00:00:15] Bob: Thanks for having me! I'm excited to discuss web development trends.

[00:00:30] Alice: Let's start with the biggest change this year - what would you say that is?

[00:00:45] Bob: I'd say it's the rise of server components in React.
```

---

## Common Issues and Solutions

### Issue: "Could not parse transcript"

**Cause:** Format doesn't match any parser pattern

**Solutions:**
1. Use **2 spaces** between name and timestamp, not 1
2. Put username and timestamp on separate lines
3. Use WhatsApp bracket format `[date] Name: message`
4. Don't use colons after timestamps (incorrect: `Name 9:30 AM: message`)

### Issue: "Detected as wrong platform"

**Cause:** Parser auto-detection picks up the first matching pattern

**Solution:** Manually select the source platform in the block settings instead of using "Auto"

### Issue: Multi-line messages not parsing

**Solution:** Make sure there's a blank line OR a new username/timestamp between messages

### Issue: Emojis not showing

**Solutio**:
- Use actual emoji characters (✅ works: 👍)
- Or use shortcodes (✅ works: `:thumbsup:`)
- Don't mix formats in the same message

---

## Testing Your Format

1. Copy one of the working examples above
2. Paste into Chat Log block
3. If you get "Could not parse transcript", check:
   - **Spacing** between name and timestamp (need 2 spaces for Format 1)
   - **Line breaks** between messages
   - **No extra characters** like colons after timestamps

---

## Parser Priority

The parser checks formats in this order:

1. WEBVTT header → VTT format
2. VTT timecodes (`00:00.000 --> 00:05.000`)
3. VTT speaker tags (`<v Name>`)
4. SRT numeric IDs and timecodes
5. Descript style (`Name (HH:MM:SS):`)
6. Bracket timecodes (`[HH:MM:SS] Name:`)
7. Slack/Discord multi-space (`Name  HH:MM AM`)
8. WhatsApp brackets (`[Date] Name: message`)
9. Username-then-timestamp (multi-line)

Use specific source selection if auto-detection picks wrong format!
