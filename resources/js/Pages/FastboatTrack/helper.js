export const generateTrack = (places, oldTrack) => {
    let tracks = [];
    if (places.length >= 2) {
        let n = places.length
        for (let i = 0; i < n; i++) {
            for (let j = i + 1; j < n; j++) {
                let previusTrack = oldTrack.find(track => track.fastboat_source_id == places[i].place.id && track.fastboat_destination_id == places[j].place.id)
                if(previusTrack) { 
                    tracks.push(previusTrack)
                } else {
                    tracks.push({
                        source: places[i].place,
                        destination: places[j].place,
                        fastboat_source_id: places[i].place.id,
                        fastboat_destination_id: places[j].place.id,
                        price: 0,
                        arrival_time: "0:0",
                        departure_time: "0:0",
                        is_publish: 1,
                    });
                }
            }
        }
    }
    return tracks;
};
